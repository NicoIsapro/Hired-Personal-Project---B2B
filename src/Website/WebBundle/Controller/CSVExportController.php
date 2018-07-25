<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Exporter\Writer\CsvWriter;
use Exporter\Handler;

class CSVExportController extends Controller
{

  public function ExportCSVAction(Request $request)
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

    $format = 'csv';
    $contentType = 'application/vnd.ms-excel';
    $writer = new CsvWriter('php://output');

    $filename = sprintf(
        'orders_table_csv_%s_' . time() . '.%s',
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
