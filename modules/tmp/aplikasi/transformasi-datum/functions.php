<?php
if(!defined('D_TRANSFORMASI_DATUM')){define('D_TRANSFORMASI_DATUM',true);
require __DIR__.'/variable.php';

function get_survey_data($id){
    $db=$GLOBALS['dbg'];
    $d=array();$datums=$db->get_results("SELECT id_datum,datum_name FROM datums ORDER BY id_datum ASC");
    foreach($datums as $k => $v)$d[(int)$v->id_datum]=$v->datum_name;
    $data=$db->get_row("SELECT a.*,b.name FROM surveys AS a JOIN users AS b ON a.id_user=b.id_user WHERE a.id_survey=$id");
    $data->old_datum=$d[(int)$data->id_old_datum];
    $data->new_datum=$d[(int)$data->id_new_datum];
    return $data;
}

function coord_list(){
    $db=$GLOBALS['dbg'];
    $data=$db->get_results("SELECT * FROM coordinate_systems");
    return $data;
}
/*
CREATE TABLE `coordinate_systems` (
  `id_sys` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_sys`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/

function get_survey_points_($id){
    $db=$GLOBALS['dbg'];
    $data=$db->get_results("SELECT * FROM survey_points WHERE id_survey=$id");
    return $data;
}
/*
CREATE TABLE `survey_points` (
  `id_point` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_survey` int(10) unsigned NOT NULL,
  `point_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `X1` double NOT NULL,
  `dX1` double DEFAULT NULL,
  `Y1` double NOT NULL,
  `dY1` double DEFAULT NULL,
  `Z1` double NOT NULL,
  `dZ1` double DEFAULT NULL,
  `X2` double NOT NULL,
  `dX2` double DEFAULT NULL,
  `Y2` double NOT NULL,
  `dY2` double DEFAULT NULL,
  `Z2` double NOT NULL,
  `dZ2` double DEFAULT NULL,
  `bursawolf_passing_status` tinyint(1) NOT NULL DEFAULT 0,
  `molobas_passing_status` tinyint(1) NOT NULL DEFAULT 0,
  `is_used` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_point`),
  KEY `id_survey` (`id_survey`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/


function get_bursawolf($id){
    $db=$GLOBALS['dbg'];
    $data=$db->get_row("SELECT * FROM bursawolf WHERE id_survey=$id");
    return $data;
/*
CREATE TABLE `bursawolf` (
  `id_bursawolf` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_survey` int(10) unsigned NOT NULL,
  `dx` double NOT NULL,
  `dx_uncertainty` double NOT NULL,
  `dy` double NOT NULL,
  `dy_uncertainty` double NOT NULL,
  `dz` double NOT NULL,
  `dz_uncertainty` double NOT NULL,
  `ex` double NOT NULL,
  `ex_uncertainty` double NOT NULL,
  `ey` double NOT NULL,
  `ey_uncertainty` double NOT NULL,
  `ez` double NOT NULL,
  `ez_uncertainty` double NOT NULL,
  `ds` double NOT NULL,
  `ds_uncertainty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bursawolf`),
  KEY `id_survey` (`id_survey`),
  CONSTRAINT `bursawolf_ibfk_1` FOREIGN KEY (`id_survey`) REFERENCES `surveys` (`id_survey`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/
}

function get_molobas($id){
    $db=$GLOBALS['dbg'];
    $data=$db->get_row("SELECT * FROM molodensky_badekas WHERE id_survey=$id");
    return $data;
/*
CREATE TABLE `molodensky_badekas` (
  `id_molobas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_survey` int(10) unsigned NOT NULL,
  `dx` double NOT NULL,
  `dx_uncertainty` double NOT NULL,
  `dy` double NOT NULL,
  `dy_uncertainty` double NOT NULL,
  `dz` double NOT NULL,
  `dz_uncertainty` double NOT NULL,
  `ex` double NOT NULL,
  `ex_uncertainty` double NOT NULL,
  `ey` double NOT NULL,
  `ey_uncertainty` double NOT NULL,
  `ez` double NOT NULL,
  `ez_uncertainty` double NOT NULL,
  `ds` double NOT NULL,
  `ds_uncertainty` double NOT NULL,
  `x_centroid` double NOT NULL,
  `y_centroid` double NOT NULL,
  `z_centroid` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_molobas`),
  KEY `id_survey` (`id_survey`),
  CONSTRAINT `molodensky_badekas_ibfk_1` FOREIGN KEY (`id_survey`) REFERENCES `surveys` (`id_survey`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/
}
}?>