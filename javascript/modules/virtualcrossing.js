function showVirtualcrossing(data, virtualcrossingDiv){
  const dl = document.createElement('dl');
  for (const day of data.days) {
    const dt = document.createElement('dt');
    dt.innerHTML = day.datetime;
    dl.append(dt);
    const dd = document.createElement('dd');
    const ul = document.createElement('ul');
    const li1 = document.createElement('li');
    li1.innerHTML = `Max temp: ${day.tempmax}degC`;
    ul.append(li1);
    const li2 = document.createElement('li');
    li2.innerHTML = `Min temp: ${day.tempmin}degC`;
    ul.append(li2);
    const li3 = document.createElement('li');
    li3.innerHTML = `Precip: ${day.precip}`;
    ul.append(li3);
    const li4 = document.createElement('li');
    li4.innerHTML = `Wind: ${day.windspeed}`;
    ul.append(li4);
    const li5 = document.createElement('li');
    li5.innerHTML = `Wind Gust: ${day.windgust}`;
    ul.append(li5);
    const li6 = document.createElement('li');
    li6.innerHTML = `Cloud cover: ${day.cloudcover}`;
    ul.append(li6);
    const li7 = document.createElement('li');
    li7.innerHTML = `Moonphase: ${day.moonphase}`;
    ul.append(li7);
    // loads more li els created and then appended to ul...
    dd.append(ul);
    dl.append(dd);
    /*
    let liContent = '';
    for(const [key, value] of Object.entries(day)){
      liContent += `${key}: ${value}<br>`;
    }
    li.innerHTML = liContent;
    */
  }
  virtualcrossingDiv.append(dl);
}

export { showVirtualcrossing };
