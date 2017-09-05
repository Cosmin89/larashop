<div class="col-md-8 col-md-offset-2">
<div class="modal fade" tabindex="-1" role="dialog" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Product</h4>
      </div>
      <div class="modal-body"> 
      <form id="frmProducts" name="frmProducts" novalidate=""> 
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="">          
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="textarea" id="description" name="description" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="text" id="image" name="image" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" id="stock" name="stock" class="form-control" value="">
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
          <input type="hidden" id="product_id" name="product_id" value="0">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<meta name="_token" content="{{ csrf_token() }}" />
