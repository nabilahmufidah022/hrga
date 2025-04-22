<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Debugbar;
/**
 * Ctrl Base Back-end Controller
 */
class CtrlBase extends Controller
{

    protected $fnExportPrefix = "Report_merapat_";
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getCurrentFilters() {
        $filters = [];
        foreach (\Session::get('widget', []) as $name => $item) {
            if (str_contains($name, 'Filter')) {
                $filter = @unserialize(@base64_decode($item));
                if ($filter) {
                    array_push($filters, $filter);
                }
            }
        }
        $res = [];
        if($filters) {
            foreach($filters as $i) {
                foreach($i as $name => $item) {
                    if(!$item) continue; 
                    $res[$name] = $item;
                }
                
            }
        }
        return $res;
    }

    protected function setDownloadXlsHeader($fn='download.xls') {
        // Redirect output to a clientâ€™s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fn.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
    }

    public function doExportXls($q, $lastCol = 'O', $colNames = ['no'], $fields = [], $columnTitleShadeColor = 'ffffe0') {
        if(!$q) {
            return false;
        }
       
        $carbonNow = CarbonImmutable::now()->timezone('Asia/Jakarta');
        
        $now = $carbonNow->format('Y-m-d H:i:s');
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'List generated at: '. $now);
        // $lastCol = 'O';
        $sheet->mergeCells("A1:".$lastCol."1");
        $n = 1;
        
        // $supplierMdl = new SupplierMdl;
        // $q = $supplierMdl->orderBy('name','asc')
        //     ->orderBy('note','asc');


        $cols = range(66,ord($lastCol));
        array_walk($cols, function(&$value) {
            $value = chr($value);
        });
        

        // $colNames = [
        //     'Supplier ID',
        //     'Code',
        //     'Name',
        //     'Phone',
        //     'Fax',
        //     'Contact Name',
        //     'Contact Phone',
        //     'Contact Email',
        //     'Address',
        //     'City',
        //     'State',
        //     'Country',
        //     'Postal Code',
        //     'Last Update',
        // ];

        array_walk($colNames, function(&$val) {
            $val = strtoupper($val);
        });
        
        
        
        // $fields = [
        //     'id',
        //     'name',
        //     'note',
        //     'phone',
        //     'fax',
        //     'contact_name',
        //     'contact_no',
        //     'contact_email',
        //     'address',
        //     'city',
        //     'state',
        //     'country',
        //     'postal_code',
        //     'updated_at',
        // ];
        $n++;
        
        $bstart = $n;
        $sheet->setCellValue( 'A'.$n, 'No');

        foreach ($colNames as $key => $item) {
            $sheet->setCellValue( $cols[$key].$n, $item);    
        }
        $sheet->getStyle(sprintf("A%s:%s%s",$n,$lastCol,$n))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($columnTitleShadeColor);
        
        $n++;
        $rs = $q->get();
        if($rs) {
            foreach($rs as $i => $data) {
               
                $x = $n+$i;
                $c = $i;
                if($n >= 65530){
                    // dd($i,$n);
                    $sheet->setCellValue( 'A'.$x, 'Limit Excedeed');
                    break;
                }
                $sheet->setCellValue( 'A'.$x, $c+1);
                foreach ($colNames as $key => $header) {
                    if(strpos($fields[$key],'.',0) !== false) {
                        list($mdl,$fld) = explode('.', $fields[$key]);
                        $val = $data->{$mdl} ? $data->{$mdl}->{$fld}:'';
                    } else {
                        $val = $data->{$fields[$key]};
                    }
                    
                    
                    $sheet->setCellValue( $cols[$key].$x, $val);    
                }
            }
        }
        $sheet->getStyle(sprintf("A%s:%s%s",$bstart,$lastCol,$n+$i))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        foreach($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
            
        $writer = new Xlsx($spreadsheet);
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        
        $fn = $this->fnExportPrefix.$carbonNow->format('Y-m-d_His') . '.xls';
        $this->setDownloadXlsHeader($fn);
        $writer->save('php://output');
        exit;
    }
        
}