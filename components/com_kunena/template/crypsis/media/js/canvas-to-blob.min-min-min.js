!function(e){var f=e.HTMLCanvasElement&&e.HTMLCanvasElement.prototype,a=e.Blob&&function(){try{return Boolean(new Blob);}catch(g){return !1;}}(),b=a&&e.Uint8Array&&function(){try{return 100===new Blob([new Uint8Array(100)]).size;}catch(g){return !1;}}(),c=e.BlobBuilder||e.WebKitBlobBuilder||e.MozBlobBuilder||e.MSBlobBuilder,d=(a||c)&&e.atob&&e.ArrayBuffer&&e.Uint8Array&&function(k){var q,i,j,l,g,h;for(q=k.split(",")[0].indexOf("base64")>=0?atob(k.split(",")[1]):decodeURIComponent(k.split(",")[1]),i=new ArrayBuffer(q.length),j=new Uint8Array(i),l=0;l<q.length;l+=1){j[l]=q.charCodeAt(l);}return g=k.split(",")[0].split(":")[1].split(";")[0],a?new Blob([b?j:i],{type:g}):(h=new c,h.append(i),h.getBlob(g));};e.HTMLCanvasElement&&!f.toBlob&&(f.mozGetAsFile?f.toBlob=function(g,h,i){i&&f.toDataURL&&d?g(d(this.toDataURL(h,i))):g(this.mozGetAsFile("blob",h));}:f.toDataURL&&d&&(f.toBlob=function(h,i,g){h(d(this.toDataURL(i,g)));})),"function"==typeof define&&define.amd?define(function(){return d;}):e.dataURLtoBlob=d;}(this);