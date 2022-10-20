<?php
$get=array('GetProfilPT','GetProdi','GetPeriode','GetListMahasiswa','GetBiodataMahasiswa','GetDataLengkapMahasiswaProdi','GetListRiwayatPendidikanMahasiswa','GetNilaiTransferPendidikanMahasiswa','GetKRSMahasiswa','GetRiwayatNilaiMahasiswa','GetAktivitasKuliahMahasiswa','GetListDosen','DetailBiodataDosen','GetListPenugasanDosen','GetAktivitasMengajarDosen','GetRiwayatFungsionalDosen','GetRiwayatPangkatDosen','GetRiwayatPendidikanDosen','GetRiwayatSertifikasiDosen','GetRiwayatPenelitianDosen','GetMahasiswaBimbinganDosen','GetListPenugasanSemuaDosen','GetListMataKuliah','GetDetailMataKuliah','GetPembiayaan','GetJenisPrestasi','GetTingkatPrestasi','GetJenisAktivitasMahasiswa','GetKategoriKegiatan','GetListPrestasiMahasiswa','GetListAktivitasMahasiswa','GetListAnggotaAktivitasMahasiswa','GetListBimbingMahasiswa','GetListUjiMahasiswa','GetAgama','GetBentukPendidikan','GetIkatanKerjaSdm','GetJabfung','GetJalurMasuk','GetJenisEvaluasi','GetJenisKeluar','GetJenisSertifikasi','GetJenisPendaftaran','GetJenisSMS','GetJenisSubstansi','GetJenisTinggal','GetJenjangPendidikan','GetKebutuhanKhusus','GetLembagaPengangkat','GetLevelWilayah','GetNegara','GetPangkatGolongan','GetPekerjaan','GetPenghasilan','GetSemester','GetStatusKeaktifanPegawai','GetStatusKepegawaian','GetStatusMahasiswa','GetTahunAjaran','GetWilayah','GetTranskripMahasiswa','GetListSubstansiKuliah','GetListKurikulum','GetDetailKurikulum','GetMatkulKurikulum','GetListKelasKuliah','GetDetailKelasKuliah','GetDosenPengajarKelasKuliah','GetPerhitunganSKS','GetPesertaKelasKuliah','GetListNilaiPerkuliahanKelas','GetDetailNilaiPerkuliahanKelas','GetListPerkuliahanMahasiswa','GetDetailPerkuliahanMahasiswa','GetListPrestasiMahasiswa','GetCountMahasiswa','GetCountPrestasiMahasiswa','GetCountAktivitasMahasiswa','GetCountRiwayatPendidikanMahasiswa','GetCountNilaiTransferPendidikanMahasiswa','GetCountDosen','GetCountPenugasanSemuaDosen','GetCountAktivitasMengajarDosen','GetCountSkalaNilaiProdi','GetCountPeriodePerkuliahan','GetCountDosenPembimbing','GetCountKelasKuliah','GetCountKurikulum','GetCountMataKuliah','GetCountMatkulKurikulum','GetCountNilaiPerkuliahanKelas','GetCountSubstansiKuliah','GetCountPerguruanTinggi','GetCountProdi','GetCountRiwayatNilaiMahasiswa','GetCountDosenPengajarKelasKuliah','GetCountMahasiswaLulusDO','GetCountPesertaKelasKuliah','GetCountPerkuliahanMahasiswa','GetCountMahasiswaBimbinganDosen','GetAlatTransportasi');
$insert=array('InsertBiodataMahasiswa','InsertRiwayatPendidikanMahasiswa','InsertNilaiTransferPendidikanMahasiswa','InsertMataKuliah','InsertPrestasiMahasiswa','InsertAktivitasMahasiswa','InsertAnggotaAktivitasMahasiswa','InsertBimbingMahasiswa','InsertUjiMahasiswa','InsertTranskripMahasiswa','InsertSubstansiKuliah','InsertKurikulum','InsertMatkulKurikulum','InsertKelasKuliah','InsertDosenPengajarKelasKuliah','InsertPesertaKelasKuliah','InsertPerkuliahanMahasiswa','InsertPeriodePerkuliahan','InsertPrestasiMahasiswa');
$update=array('UpdateBiodataMahasiswa','UpdateRiwayatPendidikanMahasiswa','UpdateNilaiTransferPendidikanMahasiswa','UpdateMataKuliah','UpdatePrestasiMahasiswa','UpdateAktivitasMahasiswa','UpdateSubstansiKuliah','UpdateKurikulum','UpdateKelasKuliah','UpdateDosenPengajarKelasKuliah','UpdateNilaiPerkuliahanKelas','UpdatePerkuliahanMahasiswa','UpdatePeriodePerkuliahan','UpdatePrestasiMahasiswa');
$delete=array('DeleteBiodataMahasiswa','DeleteRiwayatPendidikanMahasiswa','DeleteNilaiTransferPendidikanMahasiswa','DeleteMataKuliah','DeletePrestasiMahasiswa','DeleteAktivitasMahasiswa','DeleteAnggotaAktivitasMahasiswa','DeleteBimbingMahasiswa','DeleteUjiMahasiswa','DeleteTranskripMahasiswa','DeleteSubstansiKuliah','DeleteKurikulum','DeleteMatkulKurikulum','DeleteKelasKuliah','DeleteDosenPengajarKelasKuliah','DeletePesertaKelasKuliah','DeletePerkuliahanMahasiswa','DeletePeriodePerkuliahan','DeletePrestasiMahasiswa');

function load_prodi($db){
    $data=GetGeneral('GetProdi',100,0);
    $tbl='kemahasiswaan_prodi';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE kode_program_studi='$v->kode_program_studi'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('kode_program_studi'=>$v->kode_program_studi,'nama_program_studi'=>$v->nama_program_studi,'status'=>$v->status,'id_jenjang_pendidikan'=>$v->id_jenjang_pendidikan),array('%s','%s','%s','%d'));
    }
/*
CREATE TABLE `kemahasiswaan_prodi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_program_studi` varchar(10) NOT NULL,
  `nama_program_studi` varchar(50) NOT NULL,
  `status` varchar(5) NOT NULL,
  `id_jenjang_pendidikan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_agama($db){
    $data=GetGeneral('GetAgama',100,0);
    $tbl='kemahasiswaan_agama';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_agama='$v->nama_agama'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_agama'=>$v->id_agama,'nama_agama'=>$v->nama_agama),array('%d','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_agama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agama` int(11) NOT NULL,
  `nama_agama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_alattransportasi($db){
    $data=GetGeneral('GetAlatTransportasi',100,0);
    $tbl='kemahasiswaan_alattransportasi';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_alat_transportasi='$v->nama_alat_transportasi'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_alat_transportasi'=>$v->id_alat_transportasi,'nama_alat_transportasi'=>$v->nama_alat_transportasi),array('%d','%s'));
    }
/*CREATE TABLE `kemahasiswaan_alattransportasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alat_transportasi` int(11) NOT NULL,
  `nama_alat_transportasi` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_jenistinggal($db){
    $data=GetGeneral('GetJenisTinggal',100,0);
    $tbl='kemahasiswaan_jenistinggal';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_jenis_tinggal='$v->nama_jenis_tinggal'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_jenis_tinggal'=>$v->id_jenis_tinggal,'nama_jenis_tinggal'=>$v->nama_jenis_tinggal),array('%d','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_jenistinggal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_tinggal` int(11) NOT NULL,
  `nama_jenis_tinggal` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_jenjangpendidikan($db){
    $data=GetGeneral('GetJenjangPendidikan',100,0);
    $tbl='kemahasiswaan_jenistinggal';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_jenjang_didik='$v->nama_jenjang_didik'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_jenjang_didik'=>$v->id_jenjang_didik,'nama_jenjang_didik'=>$v->nama_jenjang_didik),array('%d','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_jenjangpendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenjang_didik` varchar(100) NOT NULL,
  `id_jenjang_didik` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_negara($db){
    $data=GetGeneral('GetNegara',1000,0);
    $tbl='kemahasiswaan_negara';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_negara='$v->nama_negara'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_negara'=>$v->id_negara,'nama_negara'=>$v->nama_negara),array('%s','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_negara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_negara` varchar(2) NOT NULL,
  `nama_negara` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_pekerjaan($db){
    $data=GetGeneral('GetPekerjaan',100,0);
    $tbl='kemahasiswaan_pekerjaan';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_pekerjaan='$v->nama_pekerjaan'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_pekerjaan'=>$v->id_pekerjaan,'nama_pekerjaan'=>$v->nama_pekerjaan),array('%d','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_pekerjaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int(11) NOT NULL,
  `nama_pekerjaan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_penghasilan($db){
    $data=GetGeneral('GetPenghasilan',100,0);
    $tbl='kemahasiswaan_penghasilan';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_penghasilan='$v->nama_penghasilan'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_penghasilan'=>$v->id_penghasilan,'nama_penghasilan'=>$v->nama_penghasilan),array('%d','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_penghasilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penghasilan` int(11) NOT NULL,
  `nama_penghasilan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4
*/
}
function load_wilayah($db){
    $data=GetGeneral('GetWilayah',10000,0);
    $tbl='kemahasiswaan_wilayah';
    foreach($data->data as $k => $v){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM $tbl WHERE nama_wilayah='$v->nama_wilayah'");
        if((int)$ada->jml==0)
            $db->insert($tbl,array('id_wilayah'=>$v->id_wilayah,'id_negara'=>$v->id_negara,'nama_wilayah'=>$v->nama_wilayah),array('%s','%s','%s'));
    }
/*
CREATE TABLE `kemahasiswaan_wilayah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wilayah` varchar(10) NOT NULL,
  `id_negara` varchar(3) NOT NULL,
  `nama_wilayah` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
function load_mahasiswa($db){
    $data=GetGeneral('GetProdi',10000,0);
    $prd=array();foreach($data->data as $k => $v) $prd[$v->id_prodi]=$v->kode_program_studi;
    $mhs=GetGeneral('GetListMahasiswa',10000,0);
    foreach($mhs->data as $k1 => $v1){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM kemahasiswaan_datamahasiswa WHERE nim='$v1->nim'");
        if((int)$ada->jml==0){
            $db->insert('kemahasiswaan_datamahasiswa',array('nim'=>$v1->nim,'id_prodi'=>(int)$prd[$v1->id_prodi],'id_periode'=>$v1->id_periode,'nama_status_mahasiswa'=>$v1->nama_status_mahasiswa),array('%s','%d','%d','%s'));
        }
        $id=$db->get_row("SELECT id FROM kemahasiswaan_datamahasiswa WHERE nim='$v1->nim'");
        $id=(int)$id->id;
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM kemahasiswaan_biodatamahasiswa WHERE id_datamahasiswa=$id");
        if((int)$ada->jml==0){
            $data=GetGeneral('GetBiodataMahasiswa',1,0,"id_mahasiswa='$v1->id_mahasiswa'");
            if(isset($data->data[0])){            
                $v=$data->data[0];
                $db->insert('kemahasiswaan_biodatamahasiswa',array(
                    'nama_mahasiswa'=>$v->nama_mahasiswa,
                    'jenis_kelamin'=>$v->jenis_kelamin,
                    'jalan'=>$v->jalan,
                    'rt'=>$v->rt,
                    'rw'=>$v->rw,
                    'dusun'=>$v->dusun,
                    'kelurahan'=>$v->kelurahan,
                    'kode_pos'=>$v->kode_pos,
                    'nisn'=>$v->nisn,
                    'nik'=>$v->nik,
                    'tempat_lahir'=>$v->tempat_lahir,
                    'tanggal_lahir'=>$v->tanggal_lahir,
                    'nama_ayah'=>$v->nama_ayah,
                    'tanggal_lahir_ayah'=>$v->tanggal_lahir_ayah,
                    'nik_ayah'=>$v->nik_ayah,
                    'id_jenjang_pendidikan_ayah'=>$v->id_pendidikan_ayah,
                    'id_pekerjaan_ayah'=>$v->id_pekerjaan_ayah,
                    'id_penghasilan_ayah'=>$v->id_penghasilan_ayah,
                    'id_kebutuhan_khusus_ayah'=>$v->id_kebutuhan_khusus_ayah,
                    'nama_ibu_kandung'=>$v->nama_ibu,
                    'tanggal_lahir_ibu'=>$v->tanggal_lahir_ibu,
                    'nik_ibu'=>$v->nik_ibu,
                    'id_jenjang_pendidikan_ibu'=>$v->id_pendidikan_ibu,
                    'id_pekerjaan_ibu'=>$v->id_pekerjaan_ibu,
                    'id_penghasilan_ibu'=>$v->id_penghasilan_ibu,
                    'id_kebutuhan_khusus_ibu'=>$v->id_kebutuhan_khusus_ibu,
                    'nama_wali'=>$v->nama_wali,
                    'tanggal_lahir_wali'=>$v->tanggal_lahir_wali,
                    'id_jenjang_pendidikan_wali'=>$v->id_pendidikan_wali,
                    'id_pekerjaan_wali'=>$v->id_pekerjaan_wali,
                    'id_penghasilan_wali'=>$v->id_penghasilan_wali,
                    'id_kebutuhan_khusus_mahasiswa'=>$v->id_kebutuhan_khusus_mahasiswa,
                    'telepon'=>$v->telepon,
                    'handphone'=>$v->handphone,
                    'email'=>$v->email,
                    'penerima_kps'=>$v->penerima_kps,
                    'no_kps'=>$v->nomor_kps,
                    'npwp'=>$v->npwp,
                    'id_wilayah'=>$v->id_wilayah,
                    'id_jenis_tinggal'=>$v->id_jenis_tinggal,
                    'id_agama'=>$v->id_agama,
                    'id_alat_transportasi'=>$v->id_alat_transportasi,
                    'id_negara'=>$v->id_negara,
                    'id_datamahasiswa'=>$id
                    ),array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d','%d','%s','%s','%s','%d','%d','%d','%d','%s','%s','%d','%d','%d','%d','%s','%s','%s','%d','%s','%s','%d','%d','%d','%d','%s','%d'));
            }
        }
        //*/
    }
/*
CREATE TABLE `kemahasiswaan_datamahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(100) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `nama_status_mahasiswa` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
/*
CREATE TABLE `kemahasiswaan_biodatamahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `jalan` varchar(80) NOT NULL,
  `rt` varchar(2) NOT NULL,
  `rw` varchar(2) NOT NULL,
  `dusun` varchar(60) NOT NULL,
  `kelurahan` varchar(60) NOT NULL,
  `kode_pos` varchar(5) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tempat_lahir` varchar(32) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `nik_ayah` varchar(16) NOT NULL,
  `id_jenjang_pendidikan_ayah` int(11) NOT NULL,
  `id_pekerjaan_ayah` int(11) NOT NULL,
  `id_penghasilan_ayah` int(11) NOT NULL,
  `id_kebutuhan_khusus_ayah` int(11) NOT NULL,
  `nama_ibu_kandung` varchar(100) NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `nik_ibu` varchar(16) NOT NULL,
  `id_jenjang_pendidikan_ibu` int(11) NOT NULL,
  `id_pekerjaan_ibu` int(11) NOT NULL,
  `id_penghasilan_ibu` int(11) NOT NULL,
  `id_kebutuhan_khusus_ibu` int(11) NOT NULL,
  `nama_wali` varchar(100) NOT NULL,
  `tanggal_lahir_wali` date NOT NULL,
  `id_jenjang_pendidikan_wali` int(11) NOT NULL,
  `id_pekerjaan_wali` int(11) NOT NULL,
  `id_penghasilan_wali` int(11) NOT NULL,
  `id_kebutuhan_khusus_mahasiswa` int(11) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `penerima_kps` tinyint(1) NOT NULL,
  `no_kps` varchar(80) NOT NULL,
  `npwp` varchar(15) NOT NULL,
  `id_wilayah` int(11) NOT NULL,
  `id_jenis_tinggal` int(11) NOT NULL,
  `id_agama` int(11) NOT NULL,
  `id_alat_transportasi` int(11) NOT NULL,
  `id_negara` varchar(100) NOT NULL,
  `id_datamahasiswa` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
}
/*function load_biodatamahasiswa($db){
    $mhs=GetGeneral('GetListMahasiswa',10000,0);
    foreach($mhs->data as $k1 => $v1){
        $ada=$db->get_row("SELECT COUNT(*) AS jml FROM kemahasiswaan_datamahasiswa WHERE nim='$v1->nim'");
        if((int)$ada->jml==0)
        $db->insert('kemahasiswaan_datamahasiswa',array('nim'=>$v1->nim,'id_prodi'=>$v1->id_prodi,'id_periode'=>$v1->id_periode,'nama_status_mahasiswa'=>$v1->nama_status_mahasiswa));
        $id=$db->get_row("SELECT id FROM kemahasiswaan_datamahasiswa WHERE nim='$v1->nim'");
        $id=(int)$id->id;//* /
        $data=GetGeneral('GetBiodataMahasiswa',1,0,"id_mahasiswa='$v1->id_mahasiswa'");
        if(isset($data->data[0])){
            $v=$data->data[0];
            $db->insert('kemahasiswaan_biodatamahasiswa',array(
                'nama_mahasiswa'=>$v->nama_mahasiswa,
                'jenis_kelamin'=>$v->jenis_kelamin,
                'jalan'=>$v->jalan,
                'rt'=>$v->rt,
                'rw'=>$v->rw,
                'dusun'=>$v->dusun,
                'kelurahan'=>$v->kelurahan,
                'kode_pos'=>$v->kode_pos,
                'nisn'=>$v->nisn,
                'nik'=>$v->nik,
                'tempat_lahir'=>$v->tempat_lahir,
                'tanggal_lahir'=>$v->tanggal_lahir,
                'nama_ayah'=>$v->nama_ayah,
                'tanggal_lahir_ayah'=>$v->tanggal_lahir_ayah,
                'nik_ayah'=>$v->nik_ayah,
                'id_jenjang_pendidikan_ayah'=>$v->id_pendidikan_ayah,
                'id_pekerjaan_ayah'=>$v->id_pekerjaan_ayah,
                'id_penghasilan_ayah'=>$v->id_penghasilan_ayah,
                'id_kebutuhan_khusus_ayah'=>$v->id_kebutuhan_khusus_ayah,
                'nama_ibu_kandung'=>$v->nama_ibu,
                'tanggal_lahir_ibu'=>$v->tanggal_lahir_ibu,
                'nik_ibu'=>$v->nik_ibu,
                'id_jenjang_pendidikan_ibu'=>$v->id_pendidikan_ibu,
                'id_pekerjaan_ibu'=>$v->id_pekerjaan_ibu,
                'id_penghasilan_ibu'=>$v->id_penghasilan_ibu,
                'id_kebutuhan_khusus_ibu'=>$v->id_kebutuhan_khusus_ibu,
                'nama_wali'=>$v->nama_wali,
                'tanggal_lahir_wali'=>$v->tanggal_lahir_wali,
                'id_jenjang_pendidikan_wali'=>$v->id_pendidikan_wali,
                'id_pekerjaan_wali'=>$v->id_pekerjaan_wali,
                'id_penghasilan_wali'=>$v->id_penghasilan_wali,
                'id_kebutuhan_khusus_mahasiswa'=>$v->id_kebutuhan_khusus_mahasiswa,
                'telepon'=>$v->telepon,
                'handphone'=>$v->handphone,
                'email'=>$v->email,
                'penerima_kps'=>$v->penerima_kps,
                'no_kps'=>$v->nomor_kps,
                'npwp'=>$v->npwp,
                'id_wilayah'=>$v->id_wilayah,
                'id_jenis_tinggal'=>$v->id_jenis_tinggal,
                'id_agama'=>$v->id_agama,
                'id_alat_transportasi'=>$v->id_alat_transportasi,
                'id_negara'=>$v->id_negara,
                'id_datamahasiswa'=>$id
                ),array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d','%d','%s','%s','%s','%d','%d','%d','%d','%s','%s','%d','%d','%d','%d','%s','%s','%s','%d','%s','%s','%d','%d','%d','%d','%s','%d'));
        }
        //* /
    }
/*
CREATE TABLE `kemahasiswaan_datamahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(100) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `nama_status_mahasiswa` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
*/
/*
CREATE TABLE `kemahasiswaan_biodatamahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `jalan` varchar(80) NOT NULL,
  `rt` varchar(2) NOT NULL,
  `rw` varchar(2) NOT NULL,
  `dusun` varchar(60) NOT NULL,
  `kelurahan` varchar(60) NOT NULL,
  `kode_pos` varchar(5) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tempat_lahir` varchar(32) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `nik_ayah` varchar(16) NOT NULL,
  `id_jenjang_pendidikan_ayah` int(11) NOT NULL,
  `id_pekerjaan_ayah` int(11) NOT NULL,
  `id_penghasilan_ayah` int(11) NOT NULL,
  `id_kebutuhan_khusus_ayah` int(11) NOT NULL,
  `nama_ibu_kandung` varchar(100) NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `nik_ibu` varchar(16) NOT NULL,
  `id_jenjang_pendidikan_ibu` int(11) NOT NULL,
  `id_pekerjaan_ibu` int(11) NOT NULL,
  `id_penghasilan_ibu` int(11) NOT NULL,
  `id_kebutuhan_khusus_ibu` int(11) NOT NULL,
  `nama_wali` varchar(100) NOT NULL,
  `tanggal_lahir_wali` date NOT NULL,
  `id_jenjang_pendidikan_wali` int(11) NOT NULL,
  `id_pekerjaan_wali` int(11) NOT NULL,
  `id_penghasilan_wali` int(11) NOT NULL,
  `id_kebutuhan_khusus_mahasiswa` int(11) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `penerima_kps` tinyint(1) NOT NULL,
  `no_kps` varchar(80) NOT NULL,
  `npwp` varchar(15) NOT NULL,
  `id_wilayah` int(11) NOT NULL,
  `id_jenis_tinggal` int(11) NOT NULL,
  `id_agama` int(11) NOT NULL,
  `id_alat_transportasi` int(11) NOT NULL,
  `id_negara` varchar(100) NOT NULL,
  `id_datamahasiswa` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
* /
}//*/

?>