function showDay(data, queryString, dayDiv){
  const yr = queryString.get('yr');
  const mth = queryString.get('mth');
  const dayOfMonth = queryString.get('day');
  const date = new Date(yr, mth - 1, dayOfMonth);
  let html = '';
  html += '<p>';
  html += date.toDateString();
  html += "<span id='add-span'>";
  html += `<a href='./create-event/?yr=${yr}&mth=${mth}&day=${dayOfMonth}'> + </a>`;
  html += '</span></p>';
  for(let i = 0; i < data.length; i++){
    html += '<p>';
    html += data[i]['title'];
    html += "<span id='delete-event-span'>";
    html += `<a href='./delete-event/?id=${data[i]['id']}'> - </a>`;
    html += '</span></p>';
    html += '<p>';
    html += data[i]['detail'];
    html += '</p>';
    html += '<p>***********</p>';
  }
  dayDiv.innerHTML = html;
}

export { showDay };