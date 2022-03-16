<?php require('connection.php');
$sql = $con->query("SELECT * FROM products") or die($con->error);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <div class="container p-3 rounded my-4 bg-dark ">
        <div class="d-flex align-items-center justify-content-between">
            <h2><a class="text-white text-decoration-none" href="index.php">Ecommerce</a></h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">
                Add Product
            </button>
        </div>
    </div>




    <div class="container mt-5 p-0">

        <table class="table table-hover">
            <thead class="bg-dark text-light">
                <tr>
                    <th scope="col" width="10%" class="rounded-start">Sr. No</th>
                    <th scope="col" width="15%">Image</th>
                    <th scope="col" width="10%">Name</th>
                    <th scope="col" width="10%">Price</th>
                    <th scope="col" width="35%">Description</th>
                    <th scope="col" width="25%" class="rounded-end">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($row = $sql->fetch_assoc()) { ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><img width="150px" src="<?php echo './uploads/' . $row['image']; ?>" alt="" srcset=""></td>
                        <td><?php echo $row['name']; ?> </td>
                        <td><?Php echo $row['price']; ?></td>
                        <td><?Php echo $row['desc']; ?></td>
                        <td><a class="btn editBTN btn-success" href="?edit=<?php echo $row['id'] ?>">Edit</a>
                            <button class="btn btn-danger" onclick="confirm_rem(<?php echo $row['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="number" min="1" class=" form-control" name="price" required>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control m-2" required name="desc" aria-label="With textarea"></textarea>
                        </div>
                        <div class="input-group mb-3 mt-2">
                            <label class="input-group-text">Image</label>
                            <input type="file" name="image" accept=".jpg, .png , .svg" required class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" name="addproduct" class="btn btn-primary">Add </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Edit -->


    <div class="modal fade" id="editproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" id="editname" name="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="number" min="1" id="editprice" class="form-control" name="price" required>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" id="editdesc" required name="desc" aria-label="With textarea"></textarea>
                        </div>
                        <img src="" id="editimg" width="350px" class="m-2 p-2" alt="">
                        <div class="input-group mb-3">
                            <label class="input-group-text">Image</label>
                            <input type="file" name="image" accept=".jpg, .png , .svg" class="form-control">
                        </div>
                        <input type="hidden" name="editid" id="editid">

                    </div>

                    <div class="modal-footer">`

                        <button type="submit" name="editproduct" class="btn btn-primary">Edit </button>
                    </div>
                </div>
            </form>

        </div>
    </div>




    <?php
    if (isset($_GET['edit']) && $_GET['edit'] > 0) {
        $sql = $con->query("SELECT * FROM products WHERE `id`='$_GET[edit]' ");
        $row = $sql->fetch_assoc();
        echo
        "<script>
        var editproduct = new bootstrap.Modal(document.getElementById('editproduct'), {
            keyboard: false
          })
        editproduct.show();


        document.querySelector('#editname').value=`$row[name]`
        document.querySelector('#editprice').value=`$row[price]`
        document.querySelector('#editdesc').value=`$row[desc]`
        document.querySelector('#editid').value=`$_GET[edit]`
        document.querySelector('#editimg').src=`uploads/$row[image]`
  
        
   
        </script>";
    }

    ?>





    <script>
        function confirm_rem(id) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = "crud.php?rem=" + id;
            }

        }
    </script>


</body>

</html>