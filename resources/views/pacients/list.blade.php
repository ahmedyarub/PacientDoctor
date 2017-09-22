<?php
echo '<table>
<tr>
    <th>Name</th>
    <th>Genre</th>
    <th>Phone</th>
  </tr>';
foreach ($pacients as $pacient) {
    echo "<tr>
            <td>$pacient->name</td>
            <td>$pacient->genre</td>
            <td>$pacient->phone</td>
            <td><a href='edit/$pacient->id'>edit</a></td>
            <td><a href='delete/$pacient->id'>delete</a></td>
          </tr>";



}
echo '</table>';