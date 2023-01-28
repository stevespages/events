function showDay(data, queryString, dayDiv){
  /*
  function prependZero(hrOrMin){
    let hrOrMinStr = hrOrMin.toString();
    if (hrOrMinStr.length === 1){
      hrOrMinStr = '0' + hrOrMinStr;
    }
    return hrOrMinStr;
  }
  */
  console.log('data', data);
  const yr = queryString.get('yr');
  const mth = queryString.get('mth');
  const dayOfMonth = queryString.get('day');
  const date = new Date(yr, mth - 1, dayOfMonth);
  let html = `<p><span id='date-span'>${date.toDateString()}</span>
    <span id='add-span'>
      <a href='./create-event/?yr=${yr}&mth=${mth}&day=${dayOfMonth}'> + </a>
    </span></p>`;
  for(let i = 0; i < data.length; i++){
    const hr = data[i]['hr_st'] ? data[i]['hr_st'] : '00';
    const hrStr = hr.toString().padStart(2, '0');
    const min = data[i]['min_st'] ? data[i]['min_st'] : '00';
    const minStr = min.toString().padStart(2, '0');
    html += `<article class='event-article'>
      <p>${hrStr}:${minStr}<span id='delete-event-span'>
      <a href='./delete-event/?id=${data[i]['id']}'> - </a></span></p>
      <p>${data[i]['title']}</p>
      <p>${data[i]['detail']}</p>
      </article>`;
  }
  dayDiv.innerHTML = html;
}

export { showDay };
