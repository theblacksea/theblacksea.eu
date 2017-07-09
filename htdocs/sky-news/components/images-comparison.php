<section class="content-images-comparison">
  <div class="container">
    <div class="row no-gutters">
      <?php foreach($data['images'] as $image): ?>
        <div class="col-sm-6 image" style="background-image: url('img/photo/<?=$image;?>');" data-aos="fade"></div>
      <?php endforeach; ?>
    </div>
    <div class="row no-gutters text">
      <div class="col-sm-6">
        <?php component('minus', $data['text']['minus']); ?>
      </div>
      <div class="col-sm-6">
        <?php component('plus', $data['text']['plus']); ?>
      </div>
    </div>
  </div>
</section>