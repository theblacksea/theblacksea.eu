<section class="content-image-half">
  <div class="container">
    <div class="image" data-aos="fade-right">
      <img src="img/photo/<?=$data['src'];?>" alt="" />
    </div>
    <div class="text <?=isset($data['position'])?$data['position']:'right';?>" data-aos="fade-left">
      <?php if(isset($data['text']['h1'])): ?>
        <h1><?=$data['text']['h1'];?></h1>
      <?php endif; ?>
      <?php if(isset($data['text']['h2'])): ?>
        <h2><?=$data['text']['h2'];?></h2>
      <?php endif; ?>
      <?php if(isset($data['text']['h3'])): ?>
        <h3><?=$data['text']['h3'];?></h3>
      <?php endif; ?>
      <?php if(isset($data['text']['minus'])): ?>
        <?php component('minus', $data['text']['minus']); ?>
      <?php endif; ?>
      <?php if(isset($data['text']['plus'])): ?>
        <?php component('plus', $data['text']['plus']); ?>
      <?php endif; ?>
    </div>
  </div>
</section>