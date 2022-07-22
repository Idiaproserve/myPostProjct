<?php require APPROOT . '/views/inc/header.php'; ?>

    <a href="<?php echo URLROOT; ?>/posts" class="btn mt-3 btn-light"><-Back</a>

      <div class="card card-body bg-light mt-4">
        <?php flash('register_success'); ?>
        <h2>Edit Post</h2>
        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="POST">
          <div class="form-group">
            <label for="title">Title: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">Body: <sup>*</sup></label>
            <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>">
               <?php echo $data['body']; ?>
            </textarea>
            <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
          </div>

          <div class="row mt-3">
            <div class="col">
              <input type="submit" value="Post" class="btn btn-success btn-block">
            </div>
          </div>

        </form>
      </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>