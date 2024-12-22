CREATE DATABASE uas;

USE uas;

CREATE TABLE mahasiswa (
    id_mahasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nim VARCHAR(15) NOT NULL UNIQUE,
    prodi VARCHAR(100) NOT NULL,
    nilai_mutu DECIMAL(3, 2) NOT NULL
);