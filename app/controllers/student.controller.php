<?php
require_once '../app/core/controller.php';

class student extends Controller
{
    public function index($page = 1, $limit = 10)
    public function index($page = 1, $limit  = 10, $search = "")
    {
        $search  = $_GET['search'] ?? '';

        $studentModel = $this->model("student");

        $result = $studentModel->getAllStudent($page, $limit, $search);

        $result['limit'] = $limit;
        $result['search'] = $search;

        $this->view("layouts/mainLayout", "student/index", $result);
    }

    public function create()
    {
        $lopList = $this->model("lop")->getAllClass();
        $this->view("layouts/mainLayout", "student/create", [
            'lopList' => $lopList['data'] ?? $lopList
        ]);
    }

    public function store()
    {
        $hoten    = trim($_POST['hoten']    ?? '');
        $gioitinh = trim($_POST['gioitinh'] ?? '');
        $mssv     = trim($_POST['mssv']     ?? '');
        $malop    = trim($_POST['ma_lop']   ?? '');

        try {
            $this->model("student")->createStudent($hoten, $gioitinh, $mssv, $malop);
            header("Location: /student/index");
            exit();
        } catch (\Exception $e) {
            echo "Thêm sinh viên thất bại: " . $e->getMessage();
        }
    }

    public function edit($id)
    {
        $studentModel    = $this->model("student");
        $data['student'] = $studentModel->getStudentById($id);

        if (!$data['student']) {
            echo "Không tìm thấy sinh viên!";
            return;
        }

        $lopResult      = $this->model("lop")->getAllClass();
        $data['lopList'] = $lopResult['data'] ?? $lopResult;

        $this->view("layouts/mainLayout", "student/edit", $data);
    }

    public function update($id)
    {
        $hoten    = trim($_POST['hoten']    ?? '');
        $gioitinh = trim($_POST['gioitinh'] ?? '');
        $mssv     = trim($_POST['mssv']     ?? '');
        $malop    = trim($_POST['ma_lop']   ?? '');

        try {
            $this->model("student")->updateStudent($id, $hoten, $gioitinh, $mssv, $malop);
            header("Location: /student/index");
            exit();
        } catch (\Exception $e) {
            echo "Cập nhật sinh viên thất bại: " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $this->model("student")->deleteStudent($id);
            header("Location: /student/index");
            exit();
        } catch (\Exception $e) {
            echo "Xóa sinh viên thất bại: " . $e->getMessage();
        }
    }
}