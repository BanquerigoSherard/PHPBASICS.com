<?php
include '../config/dbCon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}


if (isset($_GET['log'])) {
    if ($_GET['log'] == 'true') {
        session_destroy();
        header("Location: ../index.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>


    <div class="container">
        <h1>Dashboard</h1>
        <a href="dashboard.php?log=true">Logout</a>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            <tbody id="listUsers">
                <?php
                $sql = "SELECT * FROM users";
                $select = mysqli_query($con, $sql);


                if (mysqli_num_rows($select) != 0) {

                    while ($row = mysqli_fetch_array($select)) {

                        ?>

                        <tr>
                            <th scope="row">
                                <?php echo $row['id']; ?>
                            </th>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['created_at']; ?>
                            </td>

                            <td>
                                <button type="button" value="<?php echo $row['id']; ?>"
                                    class="btn btn-primary editBtn">Edit</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>

                        </tr>


                        <?php

                    }
                }
                ?>
            </tbody>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Email</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="userID" id="userID">

                        <!-- Inputs -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="userEmail" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary saveUser">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</body>

</html>


<script>

    $(document).ready(function () {

        $(".editBtn").on("click", function () {
            var userID = $(this).val();

            $.ajax({
                async: true,
                type: "GET",
                url: "process/editModal.php?userID=" + userID,
                dataType: "json",
                success: function (response) {

                    var email = response[1];

                    $('#userEmail').val(email);
                    $('#userID').val(userID);

                    $('#editModal').modal('show');


                }

            });


        });


        $(".saveUser").on("click", function () {

            var userID = $('#userID').val();
            var email = $('#userEmail').val();

            $.ajax({
                async: true,
                type: "GET",
                url: "process/updateUser.php?userID=" + userID + "&userEmail=" + email,
                dataType: "json",
                success: function (response) {

                    $('#editModal').modal('hide');

                    alert("User updated successfully");

                    $('#listUsers').html('');

                    for (let i = 0; i < response.length; i++) {


                        var id, email, created_at;

                        id = response[i][0];
                        email = response[i][1];
                        created_at = response[i][3];
                        $('#listUsers').append('<tr>\
                                <th scope="row">'+id+'</th >\
                                <td>'+email+'</td>\
                                <td>'+created_at+'</td>\
                            <td>\
                                <button type="button" value=""\
                                        class="btn btn-primary editBtn">Edit</button>\
                            <button type="button" class="btn btn-danger">Delete</button>\
                                </td >\
                            </tr >');

                    }












                }

            });


        });

    });


</script>