<div class="modal fade" tabindex="-1" role="dialog" id="create-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create Product</h4>
      </div>
      <form data-toggle="validator" action="{{ route('admin.create') }}" method="POST">
      <div class="modal-body">  
            <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" data-error="Please enter title" required/>
                    <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" data-error="please enter slug" required/>
                    <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="description">Description</label>
                    <input type="textarea" id="description" name="description" class="form-control" data-error="please enter description" required/>
                    <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" class="form-control" data-error="please enter price" required>
                    <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="image">Image</label>
                    <input type="text" id="image" name="image" class="form-control" data-error="please enter image" required>
                    <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" id="stock" name="stock" class="form-control" data-error="please enter stock" required>
                    <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="modal-create">Create Product</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->