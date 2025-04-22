<style>
  .container{
    max-width: 100%
  }

.panel-info{
  border: 1px solid;
  border-radius: 5px;
  border-color: #3C748F;
}


.panel-default{
  border: 1px solid;
  border-radius: 5px;
  border-color: #000000;
}

.panel-warning{
  border: 1px solid;
  border-radius: 5px;
  border-color: #856E41;
}

.panel-success{
  border: 1px solid;
  border-radius: 5px;
  border-color: #3F763E;
}

.grafico {
	min-width: 310px;
	max-width: 400px;
	height: 280px;
	margin: 0 auto
}

.main-header {
    font-size: x-large;
    color : #888;
    font-family: Verdana;
    margin-bottom: 20px;
    
}

.destaque {
    color: #f88;
    font-weight: bolder;
}

.highcharts-tooltip h3 {
    margin: 0.3em 0;
}
</style>


<div class="container">	
  
	
	<div class="col-md-3">
	    
	    <div class="panel panel-info">
          <div class="panel-heading" 
               style="background-color: #D9EDF6;
                      padding: 15px;
                      border-top-right-radius: 5px;
                      border-top-left-radius: 5px;
          ">
            <div class="row">
              <div class="col-xs-6">
                <i>
                <img src="/plugins/ppl/hrga/assets/images/db-peminjaman-user.svg">
                </i>
              </div>
              <div class="col-xs-6 text-right" style="color: #3C748F">
                <p class="announcement-heading"><?=$peminjaman?></p>
                <p class="announcement-text" style="font-size: 13px;">Peminjaman User</p>
              </div>
            </div>
          </div>
          <a href="<?= Backend::url('ppl/hrga/adminroomorders') ?>">
            <div class="panel-footer announcement-bottom" style="margin-left: 15px; margin-right: 15px;">
              <div class="row"  
                   style="background-color: #F5F5F5; 
                          border-top: 1px solid; 
                          border-color:#D1DEE4;
                          border-radius: 0px 0px 5px 5px;
                          padding: 7px 0px;
              ">
                <div class="col-xs-6">
                  Tinjau
                </div>
                <div class="col-xs-6 text-right">
                  <i class="wn-icon-circle-arrow-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        
	</div>
	
	
	

	<div class="col-md-3">
	    
	    <div class="panel panel-default">
          <div class="panel-heading"
               style="background-color: #F5F5F5;
                      padding: 15px;
                      border-top-right-radius: 5px;
                      border-top-left-radius: 5px;
          
          ">
            <div class="row">               
              <div class="col-xs-6">
              <i>
              <img src="/plugins/ppl/hrga/assets/images/db-list-ruang-rapat.svg">
              </i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading"><?=$ruangan?></p>
                <p class="announcement-text" style="font-size: 13px;"> List Ruang Rapat</p>
              </div>
            </div>
          </div>
          
          <a href="<?= Backend::url('ppl/hrga/meetingroomlists') ?>">
            <div class="panel-footer announcement-bottom" style="margin-left: 15px; margin-right: 15px;">
              <div class="row" 
                   style="background-color: #F5F5F5; 
                          border-top: 1px solid; 
                          border-color:#D1DEE4;
                          border-radius: 0px 0px 5px 5px;
                          padding: 7px 0px;
              ">
                <div class="col-xs-6">
                  Tinjau
                </div>
                <div class="col-xs-6 text-right">
                  <i class="wn-icon-circle-arrow-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        
	</div>	
	
	

	<div class="col-md-3">
	    
	    <div class="panel panel-warning">
          <div class="panel-heading"
          style="background-color: #FDF8E4;
                      padding: 15px;
                      border-top-right-radius: 5px;
                      border-top-left-radius: 5px;
          ">
            <div class="row">
              <div class="col-xs-6">
              <i>
              <img src="/plugins/ppl/hrga/assets/images/db-divisi.svg">
              </i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading"><?=$divisi?></p>
                <p class="announcement-text" style="font-size: 13px;">List Divisi</p>
              </div>
            </div>
          </div>
          <a href="<?= Backend::url('ppl/hrga/divisions') ?>">
            <div class="panel-footer announcement-bottom" style="margin-left: 15px; margin-right: 15px;">
              <div class="row"
              style="background-color: #F5F5F5; 
                          border-top: 1px solid; 
                          border-color:#D1DEE4;
                          border-radius: 0px 0px 5px 5px;
                          padding: 7px 0px;
              ">
                <div class="col-xs-6">
                  Tinjau
                </div>
                <div class="col-xs-6 text-right">
                  <i class="wn-icon-circle-arrow-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        
	</div>		
	
	


	<div class="col-md-3">
	    
	    <div class="panel panel-success">
          <div class="panel-heading"
          style="background-color: #DEF0D8;
                      padding: 15px;
                      border-top-right-radius: 5px;
                      border-top-left-radius: 5px;
          ">
            <div class="row">
              <div class="col-xs-6">
              <i>
              <img src="/plugins/ppl/hrga/assets/images/db-laporan.svg">
              </i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading"> <?= $report ?></p>
                <p class="announcement-text" style="font-size: 13px;">Laporan <i class=""></i>  </p>
              </div>
            </div>
          </div>
          <a href="<?= Backend::url('ppl/hrga/reports') ?>">
            <div class="panel-footer announcement-bottom" style="margin-left: 15px; margin-right: 15px;">
              <div class="row"
              style="background-color: #F5F5F5; 
                          border-top: 1px solid; 
                          border-color:#D1DEE4;
                          border-radius: 0px 0px 5px 5px;
                          padding: 7px 0px;
              ">
                <div class="col-xs-6">
                  Tinjau
                </div>
                <div class="col-xs-6 text-right">
                  <i class="wn-icon-circle-arrow-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        
	</div>			
	
	
	
	
	
	
</div>

