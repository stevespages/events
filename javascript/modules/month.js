function showMonth(month){
  const days = month.days;
  let monthHTML = `
    <table class='cal-ev'>
      <caption>
        <span id='left-arrow-span'> &lt; </span>
        ${month['mth-str']} ${month.yr}
        <span id='right-arrow-span'> &gt; </span>
      </caption>
      <thead>
      <tr>
        <th>M</th><th>T</th><th>W</th><th>T</th><th>F</th>
          <th>S</th><th>S</th>
      </tr>
      </thead>
      <tbody id="month-tbody">
  `;
  const date = new Date();
  const todayYr = parseInt(date.getFullYear());
  const todayMth = parseInt(date.getMonth()) + 1;
  const todayDay = parseInt(date.getDate());
  let eventsDay;
  let today = todayYr + '-' + todayMth + '-' + todayDay;
  let i = 0;
  let iStop = 7;
  while(true){
    monthHTML += '<tr>';
    for(i; i < iStop; i++){

      if(typeof days[i]['events'] !== 'undefined'){
        eventsDay = 'events';
      } else {
        eventsDay = 'no-events';
      }

      if(todayYr === month.yr && todayMth === month.mth
        && todayDay === days[i]['day']){
        today = 'today';
      } else {
        today = 'not-today';
      }

      monthHTML += `<td class=`;
      monthHTML += `'${days[i]['prev-curr-nxt']} ${eventsDay} ${today}'`;
      monthHTML += ` data-yr='${days[i]['yr']}'`;
      monthHTML += ` data-mth='${days[i]['mth']}'`;
      monthHTML += ` data-day='${days[i]['day']}'>`;
      monthHTML += `${days[i]['day']}</td>`;
    }
    monthHTML += '</tr>';
    if(typeof(days[i + 1]) !== 'undefined'){
      iStop = iStop + 7;
    } else {
      break;
    }
  }
  monthHTML += '</tbody></table>';

  return monthHTML;
}

export { showMonth };
