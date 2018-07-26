<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\StreamedResponse;
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

    $repository = $this->getDoctrine()
      ->getRepository('OrdersBundle:OrderRepository')
    ;

    $format = 'csv';
    $contentType = 'application/vnd.ms-excel';
    $writer = new CsvWriter('php://output');

    $filename = sprintf(
        'orders_table_csv_%s_' . time() . '.%s',
        date('Y_m_d', strtotime('now')),
        $format
    );

    // Export the data using anonymous function for the streamed response
    $callback = function() use ($repository, $writer) {
        Handler::create($repository, $writer)->export();
    };

    // Using the symfony streamed response
    return new StreamedResponse($callback, 200, array(
        'Content-Type'        => $contentType,
        'Content-Disposition' => sprintf('attachment; filename=%s', $filename)
    ));
  }
}
