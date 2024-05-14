<!DOCTYPE html>
<html>
<head>
  <title>View Content</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<style>
  .content {
    padding: 16px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 5px;
  }
</style>

<body>
  <div class="container">
    <?php
    include('connect.php');  // Include conn script

    $id = $_GET['id']; // Get ID from URL parameter
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
      <h3>View Content (ID: <?php echo $id; ?>)</h3>
      <br>

      <div class="content">
        <?php echo htmlspecialchars_decode($row['content']); ?>
      </div>

    <?php else : ?>
      <p>Error: Content not found!</p>
    <?php endif; ?>

  </div>
</body>
</html>
