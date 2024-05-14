<!DOCTYPE html>
<html>
<head>
  <title>Edit Content</title>
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
    <?php
    include('connect.php');  // Include conn script

    $id = $_GET['id']; // Get ID from URL parameter

    if (isset($_REQUEST['submit'])) {
      $content = trim($_POST['content']);
      //$sanitizedContent = htmlspecialchars($content, ENT_QUOTES);

      // Prepare UPDATE query
      $update_query = mysqli_prepare($conn, "UPDATE tbl_ckeditor SET content = ? WHERE id = ?");
      mysqli_stmt_bind_param($update_query, "si", $content, $id);

      if (mysqli_stmt_execute($update_query)) {
        $msg = "Content Updated Successfully!";
      } else {
        $msg = "Error: " . mysqli_error($conn);
      }

      mysqli_stmt_close($update_query);
    } else {
      $msg = "";
    }
    ?>

    <?php
    // Fetch content based on ID using prepared statement
    $get_content_query = mysqli_prepare($conn, "SELECT content FROM tbl_ckeditor WHERE id = ?");
    mysqli_stmt_bind_param($get_content_query, "i", $id);
    mysqli_stmt_execute($get_content_query);
    $result = mysqli_stmt_get_result($get_content_query);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($get_content_query);
    ?>

    <?php if (mysqli_num_rows($result) > 0) : ?>
      <h3>Edit Content (ID: <?php echo $id; ?>)</h3>
      <br>

      <?php if (!empty($msg)) : ?>
        <div class="alert alert-<?php echo ($msg == 'Content Updated Successfully!') ? 'success' : 'danger'; ?>">
          <?php echo $msg; ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="form-group">
          <textarea id="content" name="content" class="form-control"><?php echo htmlspecialchars_decode($row['content']); ?></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Update" class="btn btn-primary">
        </div>
      </form>

    <?php else : ?>
      <p>Error: Content not found!</p>
    <?php endif; ?>

  </div>

  <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#content'))
      .catch(error => {
        console.error(error);
      });
  </script>
</body>
</html>
