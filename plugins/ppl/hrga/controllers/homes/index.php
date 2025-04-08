<style>
  .fc-license-message{
    display: none !important;
  }
  .fc-prev-button{
    display: none;
    visibility: hidden;
  }
  .fc-next-button{
    display: none;
    visibility: hidden;
  }

  .fc-scrollgrid-sync-table{
    display: none;
    visibility: hidden;
  }

  .fc-today-button{
    margin
  }
</style>
 
 <script>

  document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
      
      // plugins: [resourceTimelinePlugin],
     
      initialView: 'resourceTimeGridDay',
      resources: <?= $resources ?>, 
      slotMinTime: '7:00:00',
      slotMaxTime: '20:00:00',
      events: <?= $pinjams?>,
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      height:'auto',
      
      dateClick: function(info) {
        

          console.log(info.dayEl.attributes[1].value);
          let roomid = info.dayEl.attributes[1].value;
          let dateStr = info.dateStr;
          // alert('Clicked on: ' + info.dateStr);
          
          window.location.href = "/manage/ppl/hrga/userroomorders/orderform/" + roomid +"/" + dateStr; //assuming that testing.html is in same folder as your current html file.
        
},
editable: true,
    timeRender: function(info)
    {
      info.el.innerHTML += "<button class='dayButton' data-date='" + info.date + "'>Click me</button>";
      info.el.style.padding = "20px 0 0 10px";
    }

      
      
  });

      document.getElementById('dateBtn').addEventListener('click', function () {
      var dateField = document.getElementById('dateField');
      var selectedDate = dateField.value;

      if (selectedDate) {
        // Use FullCalendar's gotoDate method to navigate to the selected date
        calendar.gotoDate(selectedDate);
      }

      
    });
  calendar.render();

  var buttons = document.querySelectorAll(".dayButton");
  buttons.forEach(function (btn){
    btn.addEventListener("click", function(e) {
      alert("clicked button on " + this.dataset.date);
    });
  })
  var today = new Date().toISOString().split('T')[0];
    // Set min attribute of dateField to today's date
    document.getElementById('dateField').setAttribute('min', today);
  
  
});


</script>
<p style="margin-left: 20px; font-weight: bold"> Cari tanggal peminjaman yang diinginkan:
<div class="input-group mb-2 " style="display: flex; margin-left: 20px">
<input type="date"  id="dateField" class="form-control" style="width: 50%; margin-right: 5px;"/>
<button type="button" id="dateBtn" class="btn btn-primary" style="width: 10%; margin-right: 5px; text-align:center">
Cari 
</button>
</div>


<hr/>


<div id='calendar' style="margin-left:20px; margin-right: 20px"></div>