<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ppl\Hrga\Controllers\CtrlBaseLeave;
use Ppl\Hrga\Models\Reportleave as LaporanLeave;
use Ppl\Hrga\Models\Leave as Leave;
use Backend\Models\User as BackendUser;

use Symfony\Component\Console\Application;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

/**
 * Reportleaves Backend Controller
 */
class Reportleaves extends CtrlBaseLeave
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var array Permissions required to view this page.
     */

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'reportleaves');
    }

    public function listExtendQuery($query) {
        $query->where('flag_status', '!=' , 4);
    }

    public function preview($id, $context='preview'){
        $id_sakit = Leave::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function exportXls() {
        date_default_timezone_set('Asia/Jakarta');
        $qMdl = new LaporanLeave;
        $q = $qMdl->orderBy('created_at','desc')->where('flag_status', '!=', 4 );

        $colNames = [
            'Nama Pengaju Cuti',
            'Unit Kerja',
            'No WA',
            'Tanggal Awal Cuti',
            'Tanggal Terakhir Cuti',
            'Jumlah Rencana Cuti',
            'Jenis Cuti',
            'Keterangan Cuti'
        ];
        $fields = [
            'nama',
            'divisi_id',
            'no_wa',
            'tanggal_awal',
            'tanggal_akhir',
            'jumlah_rencana_cuti',
            'jenis_cuti',
            'keterangan_cuti'
        ];
        $lastCol = chr(count($fields) + 65);
        $columnTitleShadeColor = 'ffffe0';
        $export = $this->doExportXls($q, $lastCol, $colNames, $fields, $columnTitleShadeColor);
        if($export === false) {
            throw new ApplicationException(Lang::get('backend::lang.form.behavior_not_ready'));
        }
        
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
                        // ini untuk relasi
                    }
                    // disini kalo mau buat kondisi numbering
                    else {
                        $val = $data->{$fields[$key]};
                    }
                    
                    $sheet->setCellValue( $cols[$key].$x, $val);
                }
            }
        }
        $sheet->getStyle(sprintf("A%s:%s%s",$bstart,$lastCol,$n+$i))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle(sprintf("A%s:%s%s",$bstart,$lastCol,$n+$i))
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle(sprintf("I%s:I%s",$bstart,$n+$i))->getAlignment()->setWrapText(true);
        $sheet->getStyle(sprintf("J%s:J%s",$bstart,$n+$i))->getAlignment()->setWrapText(true);
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
