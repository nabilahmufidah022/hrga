<style> 

    article {
      --img-scale: 1.001;
      --title-color: black;
      --link-icon-translate: -20px;
      --link-icon-opacity: 0;
      position: relative;
      border-radius: 16px;
      box-shadow: none;
      background: #fff;
      transform-origin: center;
      transition: all 0.4s ease-in-out;
      overflow: hidden;
    }
    
    article a::after {
      position: absolute;
      inset-block: 0;
      inset-inline: 0;
      cursor: pointer;
      content: "";
    }
    
    /* basic article elements styling */
    article h2 {
      margin: 0 0 18px 0;
      font-family: "Bebas Neue", cursive;
      font-size: 1.9rem;
      letter-spacing: 0.06em;
      color: var(--title-color);
      transition: color 0.3s ease-out;
    }
    
    figure {
      margin: 0;
      padding: 0;
      aspect-ratio: 16 / 9;
      overflow: hidden;
    }
    
    article img {
      max-width: 100%;
      transform-origin: center;
      transform: scale(var(--img-scale));
      transition: transform 0.4s ease-in-out;
    }
    
    .article-body {
      padding: 24px;
    }
    
    article a {
      margin:auto; 
      text-align:center; 
      display:block;
      text-decoration: none;
      color: #fff;
      margin-left: 75px;
      margin-right: 75px;
    }
    
    article a:focus {
      outline: 1px dotted #28666e;
    }
    
    article a .icon {
      min-width: 24px;
      width: 24px;
      height: 24px;
      margin-left: 5px;
      transform: translateX(var(--link-icon-translate));
      opacity: var(--link-icon-opacity);
      transition: all 0.3s;
    }
    
    /* using the has() relational pseudo selector to update our custom properties */
    article:has(:hover, :focus) {
      --img-scale: 1.1;
      --title-color: #28666e;
      --link-icon-translate: 0;
      --link-icon-opacity: 1;
      box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
    }
    
    
    /************************ 
    Generic layout (demo looks)
    **************************/
    
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }
    
    body {
    
      background-image: linear-gradient(45deg, #FAF3F0, #F3FDE8);
      /* padding-bottom: 100px; */
    
    }
    
    .articles {
      display: grid;
      max-width: 1200px;
      margin-inline: auto;
      padding-inline: 24px;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 24px;
      padding-bottom: 20px;
    }
    
    @media screen and (max-width: 960px) {
      article {
        container: card/inline-size;
      }
      .article-body p {
        display: none;
        
      }
    }
    
    @container card (min-width: 380px) {
      .article-wrapper {
        display: grid;
        grid-template-columns: 100px 1fr;
        gap: 16px;
      }
      .article-body {
        padding-left: 0;
      }
      figure {
        width: 100%;
        height: 100%;
        overflow: hidden;
      }
      figure img {
        height: 100%;
        aspect-ratio: 1;
        object-fit: cover;
      }
    }
    
    .sr-only:not(:focus):not(:active) {
      clip: rect(0 0 0 0); 
      clip-path: inset(50%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap; 
      width: 1px;
    }
    
    </style>
    
    <section class="articles">
    <?php foreach($ruangan as $row):?>
    <?php if($row->room_pics):?>  
      <article>
        <div class="article-wrapper">
          <figure>
            <img src="<?= $row->room_pics[0]->getPath()?>" alt="" />
         
          </figure>
          <div class="article-body"> 
            <h2><?= $row->room_name?></h2>
          
            <a href="<?= Backend::url('ppl/hrga/meetingrooms/update/'. $row->id) ?>" style="color: #fff; text-decoration:none; text-align: center " >
             <div class="card card-style" style="background: #ACCE22;  padding: 8px; border-radius:15px;">Lihat Detail</div>
            </a>
          </div>
        </div>
      </article>
      <?php endif;?>
      <?php endforeach; ?>
    </section>            
    
    
