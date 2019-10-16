global.config = {
  site: 
  {
      root: '/adm-golden',
      robot_panel: '/adm-golden/robots'
  },
  api: 
  {
      url: '/ws/v2/',
      user: 
      {
          login: '/ws/v2/usr/login',
          signup: '/ws/v2/usr/signup'
      },
      robot: 
      {
        auth: '/ws/v2/r/auth',
        put : '/ws/v2/r/put',
        get : '/ws/v2/r/get'
      }
  }
}

global.auth = false;
global.onRequest = false;
global.isAuthenticated = function()
{
    perform.post(config.user.login,'is_logged_in').then(function(r){
        regAuth(r)
    });
}

function regAuth(r)
{
    auth = r.res;
}
global.requestRelease = function(){
    setTimeout(function(){
        onRequest = false;
    }, 300)
}

global.resizeImage = function(img, maxWidth, maxHeight)
{
  return new Promise((resolve, reject) => {
    let image = new Image();
    image.src = URL.createObjectURL(img);
    image.onload = () => {
      let width = image.width;
      let height= image.height;

      if(width <= maxWidth && height <= maxHeight){
        resolve(img);
      }

      let newWidth;
      let newHeight;

      if(width > height){
        newHeight = height * (maxWidth / width);
        newWidth  = maxWidth;
      }else{
        newWidth = width * (maxHeight/height);
        newHeight= maxHeight;
      }

    let canvas = document.createElement('canvas');
    canvas.width = newWidth;
    canvas.height= newHeight;

    let ctx = canvas.getContext('2d');

    ctx.drawImage(image, 0, 0, newWidth, newHeight);

    canvas.toBlob(resolve, img.type)

    };
    img.onerror = reject;
  })
}
global.revstr = function(string) {
  return string.split("").reverse().join("");
}
global.req_encode = function(json){
  return revstr(
    btoa(
      revstr(
        btoa(
          revstr(
            JSON.stringify(json)
          )
        )
      )
    )
  );
}
global.perform = {
    post: function(url, service, request) {
    let req = {
      _: service,
      req: request
    }

    req = req_encode(req);

    return $.post(url, {['_']:req} , null, 'json').then(r => {
      return r;
    })
  }
}