<?php

function uploadImage($inputName, $uploadDir = "../../uploads/")
{
    // Pastikan file dipilih
    if (!isset($_FILES[$inputName])) {
        return [
            "status" => false,
            "message" => "File tidak ditemukan."
        ];
    }

    $file = $_FILES[$inputName];

    // Cek error upload
    if ($file["error"] !== UPLOAD_ERR_OK) {
        return [
            "status" => false,
            "message" => "Gagal mengupload file."
        ];
    }

    // Validasi ekstensi
    $allowedExtensions = ["jpg", "jpeg", "png", "webp"];

    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        return [
            "status" => false,
            "message" => "Format gambar harus JPG, JPEG, PNG, atau WEBP."
        ];
    }

    // Validasi ukuran maksimal 2 MB
    if ($file["size"] > 2 * 1024 * 1024) {
        return [
            "status" => false,
            "message" => "Ukuran gambar maksimal 2 MB."
        ];
    }

    // Buat nama file unik
    $newFileName = uniqid("room_", true) . "." . $extension;

    // Upload file
    if (!move_uploaded_file($file["tmp_name"], $uploadDir . $newFileName)) {
        return [
            "status" => false,
            "message" => "Gagal menyimpan gambar."
        ];
    }

    return [
        "status" => true,
        "file_name" => $newFileName
    ];
}