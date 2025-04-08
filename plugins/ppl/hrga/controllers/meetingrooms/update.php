
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: "Nunito", sans-serif;
  color: #333;
  font-weight: 300;
  line-height: 1.6; 
}

.container {
  width: 85%;
  margin: 2rem auto; 
}

.column {
  /* float: right; */
  width: 33.333333%;
  flex: 33.33%;
  padding: 5px;
}

.column img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 0 16px #333;
    transition: all 1.5s ease;
}

/* Clearfix (clear floats) */
.row{
 display: flex;

}

</style>

    <h1 style="text-align: center;"><?= $ruangan->room_name?></h1>
    <br>

    <div class="container">
        <div class="row">
          <?php foreach($ruangan->room_pics as $row):?>
          <div class="column">
            <img src="<?=$row->getpath()?>" alt="Snow" style="width:100%">
          </div>
          <?php endforeach;?>
        </div>
    </div>

    <br>
    <h3 style="font-weight:bold">Kapasitas Ruangan: </h3>
    <h4><?= $ruangan->room_capacity?> Orang</h4>

    <br>
    <h3 style="font-weight:bold">Kapasitas Ruangan: </h3>
    <h4><?= $ruangan->room_facility?> </h4>
