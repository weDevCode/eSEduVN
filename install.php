<?php 
    // Kiểm tra tên miền 
    // $_SERVER['SERVER_NAME'];
    // Kiểm tra giao thức
    // $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
    // Tạo bảng user
    // CREATE TABLE eseduvn_nguoidung ( 
    //     id INT NOT NULL AUTO_INCREMENT,
    //     tendangnhap VARCHAR(50) NOT NULL,
    //     email VARCHAR(50) NOT NULL,
    //     matkhaubam VARCHAR(255) NOT NULL,
    //     PRIMARY KEY (id), 
    //     UNIQUE (tendangnhap),
    //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // );
    // Bảng dslop
    // CREATE TABLE eseduvn_dslop (
    //     id INT NOT NULL AUTO_INCREMENT, 
    //     lop CHAR(7) NOT NULL, 
    //     khoi CHAR(7) NOT NULL, 
    //     PRIMARY KEY (id), 
    //     UNIQUE (lop)
    // );
    // 
    // Bảng dskhoi
    // CREATE TABLE eseduvn_dskhoi (
    //     id INT NOT NULL AUTO_INCREMENT,
    //     khoi CHAR(7) NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (khoi)
    //     ) ;
    // 
    // Bảng phiên đăng nhập
    // CREATE TABLE eseduvn_phien (
    //     id INT NOT NULL AUTO_INCREMENT, 
    //     tendangnhap VARCHAR(50) NOT NULL,
    //     khoaphien CHAR(255) NOT NULL, 
    //     PRIMARY KEY (id),
    //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // );
    // Bảng cài đặt
    // CREATE TABLE eseduvn_caidat ( 
    //     id INT NOT NULL AUTO_INCREMENT,
    //     tencaidat CHAR(20) NOT NULL,
    //     giatri VARCHAR(65536) NOT NULL,
    //     PRIMARY KEY (id),
    // );
    // Bảng phân quyền
    // CREATE TABLE eseduvn_caidat ( 
    //     id INT NOT NULL AUTO_INCREMENT,
    //     tendangnhap CHAR(20) NOT NULL,
    //     quyenhan VARCHAR(65536) NOT NULL,
    //     PRIMARY KEY (id),
    //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // );
    // Bảng TKB
    // CREATE TABLE eseduvn_tkb (
    //     id INT NOT NULL AUTO_INCREMENT,
    //     lop CHAR(7) NOT NULL,
    //     noidung VARCHAR(65536) NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (lop),
    //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    //     );
    // CREATE TABLE eseduvn_quyen ( 
    //     id INT NOT NULL AUTO_INCREMENT,
    //     tendangnhap VARCHAR(50) NOT NULL,
    //     hovaten VARCHAR(50) NOT NULL,
    //     chucvu CHAR(16) UNSIGNED NOT NULL,
    //     bomon CHAR(16) UNSIGNED NOT NULL,
    //     chunhiem CHAR(7) NOT NULL,
    //     diemdanh TINYINT UNSIGNED NOT NULL,
    //     tkb TINYINT UNSIGNED NOT NULL,
    //     sodaubai TINYINT UNSIGNED NOT NULL,
    //     la_admin TINYINT UNSIGNED NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (tendangnhap));
    // CREATE TABLE eseduvn_quydinh (
    //     id INT NOT NULL AUTO_INCREMENT,
    // 	   khoi CHAR(7) NOT NULL,
    //     buoi CHAR(5) NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (khoi)
    //     );
    // CREATE TABLE eseduvn_giovaotiet ( 
    //     id INT NOT NULL AUTO_INCREMENT,
    //     ten CHAR(20) NOT NULL,
    //     thoiluong TINYINT(60) NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (ten)
    // );
    // CREATE TABLE eseduvn_luutrungay (
    //     id INT NOT NULL AUTO_INCREMENT,
    //     ngay CHAR(10) NOT NULL,
    //     PRIMARY KEY (id),
    //     UNIQUE (ngay)
    // );

    // Insert

    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "sang-$i-gio",
    //     $sang["$i-gio"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "sang-$i-phut",
    //     $sang["$i-phut"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "chieu-$i-gio",
    //     $chieu["$i-gio"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "chieu-$i-phut",
    //     $chieu["$i-phut"]
    // ));
?>