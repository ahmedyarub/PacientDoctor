<?php
echo '<table>
<tr>
    <th>Name</th>
    <th>CRM</th>
    <th>Phone</th>
  </tr>';
foreach ($doctors as $doctor) {
    echo "<tr>
            <td>$doctor->name</td>
            <td>$doctor->crm</td>
            <td>$doctor->phone</td>
            <td><a href='edit/$doctor->id'>edit</a></td>
            <td><a href='delete/$doctor->id'>delete</a></td>
          </tr>";



}
echo '</table>';