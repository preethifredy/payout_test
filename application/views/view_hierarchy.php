<h1>User Hierarchy for <?php echo $user[0]['name']; ?></h1>
<table border="1">
    <thead>
        <tr>
            <th>Level</th>
            <th>User Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hierarchy as $level => $affiliate):
                $where=array('id'=>$affiliate['user_id'],'status'=>1);
                $user_name = $this->user_model->get_data('users','name',$where);
                ?>
            <tr>
                <td><?php echo $level-1; ?></td>
                <td><?php echo $user_name[0]['name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


