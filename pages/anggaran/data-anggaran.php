<?php
    if(isset($_GET['delete'])){
        $query_delete = $connect->exec("DELETE FROM anggaran WHERE id_anggaran='$_GET[delete]'");
        if($query_delete){
            $delete_stat = true;
        } else{
            $delete_stat = false;
        }
    }
    if(isset($_POST['simpan'])){
        $asal_anggaran = $_POST['asal_anggaran'];
        $query_tambah = $connect->exec("INSERT INTO anggaran(asal_anggaran) VALUES ('$asal_anggaran')");
        if($query_tambah){
            $add_stat = true;
        }else{
            $add_stat = false;
        }
    }
    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $asal_anggaran = $_POST['asal_anggaran'];
        $query_edit = $connect->exec("UPDATE anggaran SET asal_anggaran='$asal_anggaran' WHERE id_anggaran='$id'");
        if($query_edit){
            $edit_stat=true;
        }else{
            $edit_stat=false;
        }
    }
?>
<script src="src/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".click-edit").click(function(e) {
            var m = $(this).attr("id");
            $.ajax({
                url: "pages/anggaran/edit-anggaran.php",
                type: "POST",
                data : {id: m,},
                success: function (ajaxData){
                    $("#data-edit").html(ajaxData);
                }
            });
        });
    });
</script>
<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Anggaran</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Anggaran</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Simple Datatable start -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="row">
                    <button style="margin-left:10px;margin-bottom: 10px;" class="btn btn-primary btn-sm" data-target="#modaladd" data-toggle="modal">Tambah Data</button>
                    <div class="col-md-12">
                        <?php
                        if(isset($delete_stat)){
                            if($delete_stat==true) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Data Berhasil Dihapus
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button></div>";
                            }else if($delete_stat==false){
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Data Gagal Dihapus
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button></div>";
                            }
                        }
                        if(isset($add_stat)){
                            if($add_stat==true) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Data Berhasil Disimpan
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button></div>";
                            }else if($add_stat==false){
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Data Gagal Disimpan
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button></div>";
                            }
                        }
                        if(isset($add_stat)){
                            if($add_stat==true) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Data Berhasil Diubah
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button></div>";
                            }else if($add_stat==false){
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Data Gagal Diubah
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button></div>";
                            }
                        }
                        ?>
                    </div>
                    <table class="data-table stripe hover nowrap">
                        <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">No.</th>
                            <th class="table-plus datatable-nosort">Asal Anggaran</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $query = $connect->query("SELECT * FROM anggaran");
                        foreach($query as $data){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['asal_anggaran'] ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        Pilih
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item click-edit" id="<?php echo $data['id_anggaran'] ?>" href="#" data-toggle="modal" data-target="#modaledit"><i class="fa fa-pencil"></i> Edit</a>
                                        <a class="dropdown-item" href="?pages=anggaran&delete=<?php echo $data['id_anggaran'] ?>"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" name="input-anggaran" action="?pages=anggaran&tambahdata">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Anggaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-6">
                        <label>Asal Anggaran</label>
                        <input type="text" name="asal_anggaran" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-dark">Reset</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" name="input-anggaran" action="?pages=anggaran&editdata">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Data Anggaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                </div>
                <div class="modal-body" id="data-edit">
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-dark">Reset</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
