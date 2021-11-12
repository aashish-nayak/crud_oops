<?php
include "./classes.php";
$obj = new database("localhost", "root", "", "phpoops");

if(isset($_GET["del"]) && $_GET["del"]!=""){
    $obj->delete("users",["id"=>$_GET["del"]]);
    echo "<script>alert('Data Deleted from Database')</script>";
    header("Refresh:3,url=index.php");
}
if(isset($_POST["submit"])){
    array_pop($_POST);
    // $obj->dbug($_POST);
    if(!isset($_GET["edit"])){
        $obj->insert("users",$_POST);
        echo "<script>alert('Data Inserted in Database')</script>";
    }else{
        $obj->update("users",$_POST,"id=".$_GET['edit']);
        echo "<script>alert('Data Updated in Database')</script>";
    }
    header("Refresh:3,url=index.php");
}
if(isset($_GET["edit"]) && $_GET["edit"]!=""){
    $data = $obj->Qshow("users","*",'id='.$_GET["edit"]);
    $edit =  $data[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web REST API</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.0/css/boxicons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="row">
                    <div class="card w-100">
                        <h2 class="card-title text-center">Drop Your Details</h2>
                        <div class="card-body py-md-4">
                            <form action="" method="POST" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="<?php if(isset($_GET["edit"])){ echo $edit["name"]; } ?>" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="age" value="<?php if(isset($_GET["edit"])){ echo $edit["age"]; } ?>" placeholder="Age" min="0">
                                </div>

                                <div class="form-group px-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"<?php if(isset($_GET["edit"]) && $edit["gender"]=="Male"){ echo "checked"; } ?> name="gender" id="inlineRadio1" value="Male">
                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?php if(isset($_GET["edit"]) && $edit["gender"]=="Female"){ echo "checked";} ?> name="gender" id="inlineRadio2" value="Female">
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="E-mail"  value="<?php if(isset($_GET["edit"])){ echo $edit["email"]; } ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="password" placeholder="Password" <?php if(isset($_GET["edit"])){ echo 'type="text"';}else{ echo 'type="password"'; } ?> value="<?php if(isset($_GET["edit"])){ echo $edit["password"];}?>">
                                </div>
                                <div class="d-flex flex-row align-items-center justify-content-between">
                                    <button type="submit" class="submit-btn" name="submit" id="submit">Create Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12" style="max-height: 100vh;overflow-y: scroll;">
                <div class="row py-3">
                    <div class="col-12">
                        <table class="table table-hover responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>age</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id='load'>
                                <?php $data = $obj->show("users");
                                foreach ($data as $key => $val) { ?>
                                    <tr>
                                        <td><?php echo $val["id"]; ?></td>
                                        <td><?php echo $val["name"]; ?></td>
                                        <td><?php echo $val["age"]; ?></td>
                                        <td><?php echo $val["gender"]; ?></td>
                                        <td><?php echo $val["email"]; ?></td>
                                        <td><?php echo $val["password"]; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon" type="button" id="dropdownMenuButton'+i+'" data-toggle="dropdown"> <i class="bx bx-dots-horizontal-rounded" data-toggle="tooltip" data-placement="top" title="Actions"></i> </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'+i+'">
                                                    <a class="dropdown-item edit" href="index.php?edit=<?php echo $val["id"]; ?>" ><i class="bx bxs-pencil mr-2"></i> Edit Profile</a>
                                                    <a class="dropdown-item text-danger delete" href="index.php?del=<?php echo $val["id"]; ?>" onclick="if(confirm('Are You Sure want to Delete Data')){ return true}else{return false}"><i class="bx bxs-trash mr-2"></i>Remove</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="js/table.js"></script>
</body>

</html>