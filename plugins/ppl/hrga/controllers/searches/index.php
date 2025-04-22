<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author">
    <meta name="generator" >
    <title></title>

    

    <!-- Bootstrap core CSS -->
<link href="https://myjamsyar.id/styles/bootstrap.min.css" rel="stylesheet">

    <style>
        

        body {
            min-height: 75rem;
           
            }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .icon-rtl {
        padding-right: 20px;
        background: url("https://cdn-icons-png.flaticon.com/512/2370/2370264.png") no-repeat right;
        background-size: 20px;
    }

     
    
.center {
  display: flex;
  padding-top: 50px;
}

.article-card {
  width: 100%;
  height: 220px;
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  font-family: Arial, Helvetica, sans-serif;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 300ms;

}

.article-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.article-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.article-card .content {
  box-sizing: border-box;
  width: 100%;
  position: absolute;
  padding: 30px 20px 20px 20px;
  height: auto;
  bottom: 0;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
}

.article-card .date,
.article-card .title {
  margin: 0;
}

.article-card .date {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 4px;
}

.article-card .title {
  font-size: 17px;
  color: #fff;
}


    </style>
  </head>
  <body>

    <main class="container" style="padding-top: 5rem;">
    <!-- <div class="card card-style" style="height: 200px; margin: 0px 150px 0px 150px; border-radius: 14px; background: #F6F7F9; box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.25); padding: 25px 30px 46px 30px;">
            <p class="font-16 font-600">
                Cari Ruangan
            </p>
            <form method="get">
            <div class="row">
                <div class="col-12 mb-3">
                    <div>
                        <input class="form-control form-control-sm" name="date" id="actualDate" type="date" aria-label=".form-control-sm example" hidden onchange="dateFacade.value=datefacade(this.value)">
                        <input class="form-control form-control-sm" id="dateFacade" type="text" placeholder="Date" aria-label=".form-control-sm example" onclick="actualDate.showPicker()">       
                    </div>
                    
                </div>
                <div class="col-4">
                    <input class="form-control form-control-sm" type="time" name="start_time" placeholder="" aria-label=".form-control-sm example" >
                </div>
                <div class="col-1">
                    <p class="font-500" style="color: #A9A9A9; text-align: center; font-size: 1rem;">
                        s/d
                    </p>
                </div>
                <div class="col-4">
                    <input class="form-control form-control-sm" type="time" name="end_time" placeholder="" aria-label=".form-control-sm example">
                </div>
                <div class="col-3">
                    <button class="btn btn-sm" style="width: 100%; background: #ACCE22; min-height: calc(1.5em + (.5rem + 2px)); color: white; font-size: 14px; font-weight: 500;">Cari</button>
                </div>
            </div>
            </form>
        </div> -->


    <div class="card card-style" style="height: 200px; margin: 0px 150px 0px 150px; border-radius: 14px; background: #F6F7F9; box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.25); padding: 25px 30px 46px 30px;">
            <p class="font-16 font-600">
                Cari Ruangan
            </p>
            <form method="get">
    <input type="date" name="start_date" placeholder="Start Date">
    <input type="time" name="start_time" placeholder="Start Time">
    <input type="time" name="end_time" placeholder="End Time">
    <button>Cari</button>
</form>
        </div>
        <div class="row" style="margin-top: 80px;">
        <?php foreach($events as $index =>$row):?>
            <!-- <article> -->
            
                <div class="col-4" style="margin-bottom: 20px;">
                <a href="<?= Backend::url('ppl/hrga/userroomorders/create/'. $row->meetingroomlist_id) ?>">
                <div class="article-card">
                <div class="content">
                    <p class="title"><?= $row->room_name?></p>
                    <?php if($row->flaq_status >= 4 ):?>
                        <div class="card card-style" style="background: #ACCE22;  padding: 8px; border-radius:15px;">Tersedia</div>
                        <?php endif;?>
                
                </div>
                <img src="<?= $row->room_pics[0]?>"/>
                </div>
                </a> 
                </div>
                
                
            
            <!-- </article> -->

            

        <?php endforeach; ?>
        </div>


    </main>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let datefacade = (inputDate) => (new Date(inputDate)).toLocaleDateString('en-UK',{dateStyle: 'medium'});
    </script>

      
  </body>
</html>
