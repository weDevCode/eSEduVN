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
    //     `id` INT NOT NULL AUTO_INCREMENT,
    //     `lop` CHAR(7) NOT NULL,
    //     `noidung` VARCHAR(65536) NOT NULL,
    //     PRIMARY KEY (`id`),
    //     UNIQUE (`lop`),
    //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    //     );
?>