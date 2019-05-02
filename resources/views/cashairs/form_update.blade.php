<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
    <div class="fileupload fileupload-new" data-provides="fileupload">
    <span class="btn btn-primary btn-file"><span class="fileupload-new">صورة الكاشير</span>
    <span class="fileupload-exists">تغير</span>
    <input type="file" name="image"/></span>
        <span class="fileupload-preview"></span>
        <a href="#" required class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
        <span class="help-block with-errors errorName"></span>
    </div>
</div>

<div class="form-group" style="display:none;">
    <label for="exampleInputFile">pic path</label>
    <input type="text" name="image" id="image" required>
</div>

<div class="form-group">
    <label for="exampleInputPassword1">أسم الكاشير</label>
    <input type="text" name="username" required class="form-control">
    <span class="help-block with-errors errorName"></span>
</div>

<div class="form-group">
    <label for="exampleInputPassword1">أسم العرض</label>
    <input type="text" name="display_name" required class="form-control">
    <span class="help-block with-errors errorName"></span>
</div>


<div class="form-group">
    <label for="exampleInputPassword1">رقم الهاتف</label>
    <input type="text" name="phone" required class="form-control">
    <span class="help-block with-errors errorName"></span>
</div>

<div class="form-group">
    <label for="exampleInputFile">حظر الكاشير</label>
    <select  class="form-control" name="is_blocked">
        <option value="1">حظر</option>
        <option value="0">ألغاء الحظر</option>
    </select>
</div>









