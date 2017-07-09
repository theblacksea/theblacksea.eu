<section class="content-image-full">
  <div class="image" style="background-image: url('img/photo/<?=$data['src'];?>');" data-aos="fade" data-aos-duration="800"></div>
  <div class="text <?=isset($data['position'])?$data['position']:'right';?>" data-aos="fade" data-aos-duration="1200">
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
    <?php if(isset($data['text']['p'])): ?>
      <?php foreach($data['text']['p'] as $paragraph): ?>
        <p><?=$paragraph;?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>