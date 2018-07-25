<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Exporter\Writer\JsonWriter;
use Exporter\Handler;

class JSONExportController extends Controller
{

  public function ExportJSONAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
      throw new AccessDeniedException('Access restricted for clients only');
    }
    $username = $this->get('security.token_storage')->getToken()->getUser();
    $username->getUsername();
    $doctrineDatabaseConnection = $this->get('database_connection');

    $sqlQuery = "SELECT products.name as 'Name',
                products.description as 'Email',
                users.username as 'Buyer',
                orders.status as 'Status',
                products.price as 'price',
                categories.name as 'Category',
                orders.date as 'Date'
                FROM orders
                JOIN users ON orders.userid = users.id
                JOIN products ON orders.prodid = products.id
                JOIN categories ON products.categid = categories.id
                WHERE users.name = '$username'";
    // Preparing Source Data Iterator via DoctrineDBALConectionIterator
    $sourceIterator = new DoctrineDBALConnectionSourceIterator($doctrineDatabaseConnection, $sqlQuery);

    $format = 'json';
    $contentType = 'application/json';
    $writer = new JsonWriter('php://output');

    $filename = sprintf(
        'orders_table_json_%s_' . time() . '.%s',
        date('Y_m_d', strtotime('now')),
        $format
    );

    // Export the data using anonymous function for the streamed response
    $callback = function() use ($sourceIterator, $writer) {
        Handler::create($sourceIterator, $writer)->export();
    };

    // Using the symfony streamed response
    return new StreamedResponse($callback, 200, array(
        'Content-Type'        => $contentType,
        'Content-Disposition' => sprintf('attachment; filename=%s', $filename)
    ));
  }
}
