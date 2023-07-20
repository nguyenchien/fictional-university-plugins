<ul class="professor-cards">
  <li class="professor-card__list-item">
    <a href="<?php the_permalink(); ?>" class="professor-card">
      <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
      <span class="professor-card__name"><?php the_title(); ?></span>
    </a>
  </li>
</ul>