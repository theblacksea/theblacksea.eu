<section class="content-text">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <?php foreach($data as $paragraph): ?>
          <p><?=nl2br($paragraph);?></p>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>