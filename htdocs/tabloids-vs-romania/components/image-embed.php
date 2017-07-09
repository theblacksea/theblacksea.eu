<section class="content-image-embed" data-aos="fade" data-aos-duration="800">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="image">
          <img src="img/photo/<?=$data['src'];?>" alt="" <?=isset($data['class']) ? 'class="' . $data['class'] .'"' : '';?> />
        </div>
        <?php if(isset($data['caption'])): ?>
          <div class="caption">
            <p><?=$data['caption'];?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>