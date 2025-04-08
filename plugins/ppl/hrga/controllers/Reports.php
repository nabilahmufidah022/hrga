<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ppl\Hrga\Controllers\CtrlBase;
use Ppl\Hrga\Models\Userroomorder as UserForm;
use Ppl\Hrga\Models\Meetingroomlist as MoMeetingRoom;

use Symfony\Component\Console\Application;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
/**
 * Reports Backend Controller
 */
class Reports extends CtrlBase
{
    protected $partialsDir = 'ppl/hrga/partials/';
    // public $requiredPermissions = ['jamsyar.merapat.peminjaman.laporan'];
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'reports');
    }

    public function listExtendQuery($query) {
        
        date_default_timezone_set('Asia/Jakarta');
        $tgl_now = Carbon::now();
        
        $query->where('tanggal_akhir', '<=', $tgl_now );
          
        
    }

    public function exportXls() {
        // if(!$this->user->hasAccess('morvs.mradmin.budgets.export')) {
        //     return Backend::redirect('morvs/mradmin/budgets');
        // }

        
        // dd($coco["coba"]);
        
        // $json = json_decode($coba_nih, true);
        // dd($json);
        date_default_timezone_set('Asia/Jakarta');
        $tgl_now = Carbon::now();
        
        $filter = $this->getCurrentFilters();
        $qMdl = new UserForm;
        // $q = $qMdl->where('tanggal_akhir', '<=', $tgl_now )->orwhere('flaq_status',[2,4])->orderBy('tanggal_awal','desc');
        //kalau querynay pake orwhere tidak bisa
        $q = $qMdl->orderBy('tanggal_awal','desc')->where('tanggal_akhir', '<=', $tgl_now );
        // $q = $qMdl->orderBy('tanggal_awal','desc');

   
        if($filter) {
            if(isset($filter['scope-ruangan']) && isset($filter['scope-tanggal_awal'])){
                $q->whereIn('meetingroomlist_id', array_keys($filter['scope-ruangan']))->whereBetween('tanggal_awal', [($filter['scope-tanggal_awal']), ($filter['scope-tanggal_awal'])]);
            }elseif(isset($filter['scope-ruangan'])){
                $q->whereIn('meetingroomlist_id', array_keys($filter['scope-ruangan']));
            } elseif(isset($filter['scope-tanggal_awal'])) {
                $q->whereBetween('tanggal_awal', [($filter['scope-tanggal_awal']), ($filter['scope-tanggal_awal'])]);
            }
        }
        
        $colNames = [
            'Nama Peminjam Ruangan',
            'Ruang Rapat',
            'Tanggal Peminjaman Awal',
            'Tanggal Peminjaman Akhir',
            'Jumlah Peserta Rapat',
            'Jenis Rapat',
            'Agenda Rapat',
            'Nama Peserta',
            'Nama Mitra',
            // 'Last Update',
        ];
        $fields = [
            'nama',
            'ruangan.room_name',
            'tanggal_awal',
            'tanggal_akhir',
            'jumlah_peserta',
            'jenis_rapat',
            'agenda_rapat',
            'nama_peserta_rapat',
            'nama_mitra',
            // 'budget_amt',
            // 'budget_curr',
            // 'updated_at',
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
                    if($fields[$key] === 'nama_peserta_rapat') {
                        $val = "";
                        if(is_array($data->{$fields[$key]})) {
                            foreach($data->{$fields[$key]} as $peserta) {
                                $val .= $peserta['nama_peserta'] ."\n";
                            }
                        }
                    }
                    elseif($fields[$key] === 'nama_mitra') {
                        $val = "";
                        if(is_array($data->{$fields[$key]})) {
                            foreach($data->{$fields[$key]} as $peserta) {
                                $val .= $peserta['nama_mitra'] ." - ". $peserta['nomor'] ."\n";
                            }
                        }
                    }
                    elseif(strpos($fields[$key],'.',0) !== false) {
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

    
    // public function exportData($columns, $sessionKey = null)
    // {
    //     $subscribers = Reports::all();
    //     $subscribers->each(function($subscriber) use ($columns) {
    //         $subscriber->addVisible($columns);
    //     });
    //     return $subscribers->toArray();
    // }
}
