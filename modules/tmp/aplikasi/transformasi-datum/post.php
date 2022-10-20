<?php

if(isset($_POST['survey_name'])){
    $id=(int)$_SESSION['id'];
    if($id<=0)$id=1;
    $dbg->insert("surveys",array(
        'survey_name'=>$_POST['survey_name'],
        'survey_date'=>$_POST['survey_date'],
        'id_old_datum'=>$_POST['old_datum'],
        'id_new_datum'=>$_POST['new_datum'],
        'description'=>$_POST['description'],
        'id_user'=>$id,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'file'=>NULL,
        'is_calculated'=>NULL
        ),
            array(
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%d',
        '%s',
        '%s',
        '%s',
        '%d'
        ));
    header("location: /".D_PAGE);
}
/*
CREATE TABLE `surveys` (
  `id_survey` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `survey_date` date NOT NULL,
  `id_old_datum` int(10) unsigned NOT NULL,
  `id_new_datum` int(10) unsigned NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_calculated` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_survey`),
  KEY `id_old_datum` (`id_old_datum`),
  KEY `id_new_datum` (`id_new_datum`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`id_old_datum`) REFERENCES `datums` (`id_datum`) ON DELETE CASCADE,
  CONSTRAINT `surveys_ibfk_2` FOREIGN KEY (`id_new_datum`) REFERENCES `datums` (`id_datum`) ON DELETE CASCADE,
  CONSTRAINT `surveys_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/
?>