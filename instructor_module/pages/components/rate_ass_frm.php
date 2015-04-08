<div class="modal fade" id="rate_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Rate Assignment</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:rate_ass()" role="form" id="arf">
          <p id='rs'></p>
          <input type='hidden' id='sub_id' value=''/>
          <div class="form-group">
            <label>Score</label>
            <input type="text" id="rate" name="rate" class="form-control" style="width:100px;"/>
          </div>
          </br>
          <div class="form-groupp">
            <label>Message</label>
            <textarea id="msg" name="msg" class="form-control"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type='submit' class="btn btn-primary"> Submit </a>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->