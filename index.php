<?php

require('db.php');

$db = new Db;

if (isset($_GET['action']) && strtolower($_GET['action']) == "submitadd")
{
    if ($_POST['name'] != '' && $_POST['due_date'] != '')
    {
        $db->insert_todo($_POST['name'], $_POST['due_date']);
    }

    header('Location: index.php');
}
else if (isset($_GET['action']) && strtolower($_GET['action']) == "submitedit")
{
    if ($_POST['name'] != '' && $_POST['due_date'] != '' && $_POST['id'] > 0)
    {
        $db->update_todo($_POST['id'], $_POST['name'], $_POST['due_date']);
    }

    header('Location: index.php');
}
else if (isset($_GET['action']) && strtolower($_GET['action']) == "submitdelete")
{
    if ($_POST['id'] > 0)
    {
        $db->delete_todo($_POST['id']);
    }

    header('Location: index.php');
}
else if (isset($_GET['action']) && strtolower($_GET['action']) == "add")
{
    ?>
    <form action="?action=submitadd" method="post">
        <label for="name">TASK NAME</label><input type="text" id="name" name="name"><br />
        <label for="due_date">DUE DATE</label><input type="text" id="due_date" name="due_date"><br />
        <button type="submit">ADD</button>
    </form>
    <?php
}
else if (isset($_GET['action']) && strtolower($_GET['action']) == "delete")
{
    $task = $db->get_todo($_GET['id']);
    ?>
    <form action="?action=submitdelete" method="post">
        <input type="hidden" name="id" value="<?php print $task['id']; ?>" />
        <p>Are you sure you want to delete this task?</p>
        <button type="submit">YES, DELETE!</button>
    </form>
    <?php
}
else if (isset($_GET['action']) && strtolower($_GET['action']) == "edit" && isset($_GET['id']) && $_GET['id'] > 0)
{
    $task = $db->get_todo($_GET['id']);
    ?>
    <h4>EDITING TASK NO: <?php print $task['id']; ?></h4>
    <form action="?action=submitedit" method="post">
        <input type="hidden" name="id" value="<?php print $task['id']; ?>" />
        <label for="name">TASK NAME</label><input type="text" id="name" name="name" value="<?php print $task['name']; ?>"><br />
        <label for="due_date">DUE DATE</label><input type="text" id="due_date" name="due_date" value="<?php print $task['due_date']; ?>"><br />
        <button type="submit">EDIT</button>
    </form>
    <?php
}
else
{
?>
<a href="?action=add">ADD NEW TASK</a>
<br />
<br />
<table>
    <thead>
        <tr>
            <th>NAME</th><th>DUE DATE</th><th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($db->get_all_todo() as $todo)
            {
                print "<tr>";
                print_r("<td>" .$todo['name'] ."</td>");
                print_r("<td>" .$todo['due_date'] ."</td>");
                print_r("<td>[ <a href='?action=edit&id=" .$todo['id'] ."'>EDIT</a> ] [ <a href='?action=delete&id=" .$todo['id'] ."'>DELETE</a> ]</td>");
                print "</tr>";
            }
        ?>
    </tbody>
</table>
<?php } ?>
