<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Meetingroomlist;
use Winter\Storm\Database\Updates\Seeder;
// use Seeder;

class Dml003SeederRoomMeeting extends Seeder
{   
    public function run()
    {
        $cek = Meetingroomlist::find(7);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["record Meetingroomlist 7 exists"]);
            return false; 
        }

        $meetingroomlist = Meetingroomlist::insert([
            [
            'id'                   => 1,
            'room_name'            => 'Ruang Rapat Lt. 3',
            'room_capacity'        => 10,
            'room_facility'        => 'Ruangan ini Ruang rapat dilengkapi dengan meja yang kokoh, kursi yang nyaman, dan dilengkapi dengan smartboard untuk mendukung presentasi yang interaktif dan efektif.'
            ],
            [
            'id'                   => 2,
            'room_name'            => 'Ruang Rapat Lt. 4',
            'room_capacity'        => 15,
            'room_facility'        => 'Ruangan ini dilengkapi dengan meja yang kokoh, kursi empuk yang nyaman, dan dilengkapi dengan proyektor untuk mendukung presentasi yang jelas dan informatif.'
            ],
            [
            'id'                   => 3,
            'room_name'            => 'Ruang Rapat Lt. 4 Gedung Annex',
            'room_capacity'        => 15,
            'room_facility'        => 'Ruangan ini dilengkapi dengan meja yang kokoh, kursi empuk yang nyaman, dan dilengkapi dengan proyektor untuk mendukung presentasi yang jelas dan informatif.'
            ],
            [
            'id'                   => 4,
            'room_name'            => 'Ruang Aula Lantai 7',
            'room_capacity'        => 20,
            'room_facility'        => 'Ruang rapat dilengkapi dengan meja dan kursi yang nyaman, dilengkapi dengan smartboard untuk presentasi yang interaktif. Selain itu, tersedia juga fasilitas toilet untuk kenyamanan pengguna, serta tempat sampah untuk menjaga kebersihan ruangan.'
            ],
            [
            'id'                   => 5,
            'room_name'            => 'Ruang Dewan Komisaris',
            'room_capacity'        => 6,
            'room_facility'        => 'Ruangan ini dilengkapi dengan meja dan kursi yang nyaman, dilengkapi dengan smartboard untuk presentasi yang interaktif. Selain itu, tersedia juga fasilitas toilet untuk kenyamanan pengguna, serta tempat sampah untuk menjaga kebersihan ruangan.'
            ],
            [
            'id'                   => 6,
            'room_name'            => 'Ruang Holding 1',
            'room_capacity'        => 4,
            'room_facility'        => 'Ruang rapat dilengkapi dengan meja yang panjang dan kursi yang nyaman, memberikan fleksibilitas dalam pengaturan ruangan untuk berbagai keperluan rapat dan pertemuan.'
            ],
            [
            'id'                   => 7,
            'room_name'            => 'Ruang Holding 2',
            'room_capacity'        => 4,
            'room_facility'        => 'Ruang rapat dilengkapi dengan meja yang panjang dan kursi yang nyaman, memberikan fleksibilitas dalam pengaturan ruangan untuk berbagai keperluan rapat dan pertemuan.'
            ],
        ]);
    }

}