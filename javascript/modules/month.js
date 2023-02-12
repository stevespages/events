function showMonth(month){
  const days = month.days;
  // caption element is hidden by css. It is for screen readers etc.
  // caption element is relaced by <div id='table-caption-div'>
  // The link to the page for authentication (<span id='user-icon) needs...
  // ...to be replaced by a variable from a config file as it will vary...
  // ...between different deployments of this app. Same for PHP.
  let monthHTML = `
    <div id='table-caption-div'>
    <span id='left-arrow-span'> &lt; </span>
    <span id='txt'>${month['mth-str']} ${month.yr}</span>
    <span id='right-arrow-span'> &gt; </span>
    <span id='user-icon'><a href='../'>&#x1F464</a></span>
    </div>
    <table class='cal-ev'>
      <caption>
        ${month['mth-str']} ${month.yr}
      </caption>
      <thead>
      <tr>
        <th>M</th><th>T</th><th>W</th><th>T</th><th>F</th>
          <th>S</th><th>S</th>
      </tr>
      </thead>
      <tbody id='month-tbody'>
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

      if(todayYr === days[i]['yr'] && todayMth === days[i]['mth']
        && todayDay === days[i]['day']){
        today = 'today selected-day';
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
