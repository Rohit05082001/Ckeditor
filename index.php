<!DOCTYPE html>
<html>
<head>
  <title>CKEditor Integration</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<style>
  .box {
    width: 100%;
    max-width: 600px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 16px;
    margin: 0 auto;
  }
  .ck-editor__editable[role="textbox"] {
    /* editing area */
    min-height: 300px;
  }
  .error {
    color: red;
  }
</style>

<body>
  <div class="container">
    <h3 align="center">CKEditor Integration</h3>
    <br>

    <?php
    include('connect.php');  // Include connection script

    if (isset($_REQUEST['submit'])) {
      $content = $_REQUEST['content'];
    

      // Prepare and execute the INSERT query
      $insert_query = mysqli_query($conn, "INSERT INTO tbl_ckeditor set content='$content'");
    

      if ($insert_query) {
        $msg = "Data Inserted Successfully!";
      } else {
        $msg = "Error: " . mysqli_error($connection);
      }

      // Close prepared statement
      mysqli_stmt_close($insert_query);
    } else {
      $msg = "";
    }
    ?>
    

    <div class="box">
      <form method="post">
        <div class="form-group">
          <textarea id="content" name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Save" class="btn btn-primary">
        </div>
      </form>
      <div class="error"><?php if(!empty($msg)) {echo $msg;}?></div>
      
    </div>
  </div>
  <div>
    <?php 
    $sql = "SELECT id, content from tbl_ckeditor";
    $result = mysqli_query($conn,$sql);

    ?>
    <?php if (mysqli_num_rows($result) > 0) : ?>
      <h2>Existing Articles</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">View</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else : ?>
      <p>No articles found.</p>
    <?php endif; ?>
  </div>
  

  
</body>
</html>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#content'))
      .catch(error => {
        console.error(error);
      });
  </script>
