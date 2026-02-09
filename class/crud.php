<?php
session_start();

class crud
{
    public function delete($query, $konek, $data) {
        if ($konek->query($query) === TRUE) {
            $this->setFlashMessage('success', "Data $data berhasil dihapus!");
            return true;
        } else {
            $this->setFlashMessage('danger', "Gagal menghapus data $data: " . $konek->error);
            return false;
        }
    }

    public function addData($query, $konek, $data) {
        if ($konek->query($query) === TRUE) {
            $this->setFlashMessage('success', "Data $data berhasil ditambahkan!");
            return true;
        } else {
            $this->setFlashMessage('error', "Data $data gagal ditambahkan!");
            return false;
        }
    }

    public function multiAddData($queryCek, $multiQuery, $konek, $data) {
        if ($konek->query($queryCek)->num_rows > 0) {
            $this->setFlashMessage('error', "Data $data sudah ada!");
        } else {
            if ($konek->multi_query($multiQuery) === TRUE) {
                $this->setFlashMessage('success', "Data $data berhasil ditambahkan!");
            } else {
                $this->setFlashMessage('error', "Data $data gagal ditambahkan!");
            }
        }
    }

    public function update($query, $konek, $data, $url) {
        if ($konek->multi_query($query) === TRUE) {
            $this->setFlashMessage('success', "Data $data berhasil diubah!");
            header("location:.".$url);
            exit;
        } else {
            $this->setFlashMessage('error', "Data $data gagal diubah!");
        }
    }

    public function multiUpdate($queryCek, $multiQuery, $konek, $data, $url) {
        if ($konek->query($queryCek)->num_rows > 0) {
            $this->setFlashMessage('error', "Data $data sudah ada!");
        } else {
            if ($konek->multi_query($multiQuery) === TRUE) {
                $this->setFlashMessage('success', "Data $data berhasil diubah!");
                header("location:.".$url);
                exit;
            } else {
                $this->setFlashMessage('error', "Data $data gagal diubah!");
            }
        }
    }

    public function setFlashMessage($type, $message) {
        $_SESSION['alert'] = ['type' => $type, 'message' => $message];
    }
}
