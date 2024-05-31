
<h1>Add User</h1>

<?php
$attr = array(
    'name'          => 'frm',
    'id'            => 'frm',
    'autocomplete'  => 'off',
);
$action = base_url().'add-user';
echo form_open($action, $attr);

?>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" maxlength="50" required value="">
    <br>
    <button type="button" onclick="validate()" >Add User</button>
<?php echo form_close(); ?>

<script>
function validate(){
    if(document.getElementById('username').value ==''){
        alert('Please enter the name');
        return false;
    }
    document.frm.submit();
}
</script>
