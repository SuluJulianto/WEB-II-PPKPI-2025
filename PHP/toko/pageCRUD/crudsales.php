<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    $site_root = $_SESSION["site_root"];

    require_once $_SESSION["dir_root"] . '/module/dbconnect.php';

        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $sales = [];
        if ($id > 0){
            $stmt = db()->prepare("SELECT * FROM sales WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $sales = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD SALES</title>
    <script>
    const base_url = "<?= $site_root?>";
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container-fluid">
        <form id="salesForm" method="post" enctype="multipart/form-data">
            <input hidden name="id" id="id" value="<?= $sales['id'] ?? '' ?>">
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text w-25">Tanggal</span>
                        <input type="text" class="form-control" placeholder="DD-MM-YYYY" name="sales_date"
                            id="sales-date" value="<?= $sales['sales_date'] ?? '' ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text w-25">Customer</span>
                        <select name="customer" id="customer" class="form-select">
                            <option value="Pilih Customer"></option>
                            <?php
                                $stmt = db()->prepare("SELECT * FROM customer ORDER BY customer");
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    if (isset($sales['id_customer']) and $sales['id_customer'] == $row['id'] ){
                                        echo '<option value="' . $row['id'] . '" selected' . '>' . $row['customer'] . '</option>';
                                    } else {
                                        echo '<option value="' . $row['id'] . '">' . $row['customer'] . '</option>';
                                    }
                                    
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div><button id="btn_save">Save</button><button id="btn_cancel">Cancel</button></div>
        </form>
    </div>
    <script src="<?= $site_root?>/JS/setSales.js"></script>
</body>

</html>
