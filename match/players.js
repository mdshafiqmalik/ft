let players = [
  {
    name:"J Buttler",
    credit:9,
    points:354,
    role:"WK",
    nationaity:"ENG"
  },
  {
    name:"M Rizwan",
    credit:9,
    points:255,
    role:"WK",
    nationaity:"PAK"
  },
  {
    name:"P Salt",
    credit:7,
    points:12,
    role:"WK",
    nationaity:"ENG"
  },
  {
    name:"M Haris",
    credit:6.5,
    points:162,
    role:"WK",
    nationaity:"PAK"
  },
  {
    name:"A Hales",
    credit:9,
    points:329,
    role:"BAT",
    nationaity:"ENG"
  },
  {
    name:"B Azam",
    credit:8.5,
    points:157,
    role:"BAT",
    nationaity:"PAK"
  },
  {
    name:"M Ali",
    credit:8,
    points:77,
    role:"BAT",
    nationaity:"ENG"
  },
  {
    name:"S Masood",
    credit:8,
    points:205,
    role:"BAT",
    nationaity:"PAK"
  },
  {
    name:"Iftikhar Ahmed",
    credit:8,
    points:225,
    role:"BAT",
    nationaity:"PAK"
  },
  {
    name:"D Malan",
    credit:7.5,
    points:92,
    role:"BAT",
    nationaity:"ENG"
  },
  {
    name:"H Brook",
    credit:7,
    points:59,
    role:"BAT",
    nationaity:"ENG"
  },
  {
    name:"A Ali",
    credit:6.5,
    points:6,
    role:"BAT",
    nationaity:"PAK"
  },
  {
    name:"S Khan",
    credit:9,
    points:467,
    role:"AR",
    nationaity:"PAK"
  },
  {
    name:"Ben Stokes",
    credit:8.5,
    points:9,
    role:"AR",
    nationaity:"ENG"
  },
  {
    name:"L Livingstone",
    credit:8,
    points:201,
    role:"AR",
    nationaity:"ENG"
  },
  {
    name:"M Nawaz",
    credit:7.5,
    points:193,
    role:"AR",
    nationaity:"PAK"
  },
  {
    name:"M Wood",
    credit:9,
    points:259,
    role:"BL",
    nationaity:"ENG"
  },
  {
    name:"S Afridi",
    credit:9,
    points:348,
    role:"BL",
    nationaity:"PAK"
  },
  {
    name:"H Rauf",
    credit:8.5,
    points:229,
    role:"BL",
    nationaity:"PAK"
  },
  {
    name:"C Woakes",
    credit:8.5,
    points:155,
    role:"BL",
    nationaity:"ENG"
  },
  {
    name:"Naseem Shah",
    credit:8,
    points:136,
    role:"BL",
    nationaity:"PAK"
  },
  {
    name:"Abdul Rashid",
    credit:7.5,
    points:118,
    role:"BL",
    nationaity:"ENG"
  },
  {
    name:"M Wasim",
    credit:7.5,
    points:313,
    role:"BL",
    nationaity:"ENG"
  },
  {
    name:"C Jordan",
    credit:7,
    points:87,
    role:"BL",
    nationaity:"ENG"
  },
];
document.getElementById('table').innerHTML = `<table id="table">
  <tr>
    <th>Name</th>
    <th>Credit</th>
    <th>Points</th>
    <th>Role</th>
    <th>Nationaity</th>
  </tr>
</table>`;
for (var i = 0; i < players.length; i++) {

  document.getElementById('table').innerHTML += `
  <tr>
  <td>${players[i].name}</td>
  <td>${players[i].credit}</td>
  <td>${players[i].points}</td>
  <td>${players[i].role}</td>
  <td>${players[i].nationaity}</td>
  </tr>


  `;
}
