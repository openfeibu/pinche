;(function(window) {

  var svgSprite = '<svg>' +
    '' +
    '<symbol id="icon-svg26" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M660.192 599.68l-89.984-89.984 90.112-90.112c14.208-14.208 14.176-37.248 0-51.456-14.208-14.208-37.184-14.24-51.456 0l-90.112 90.112L428.8 368.256c-14.208-14.208-37.312-14.176-51.488 0-14.208 14.208-14.24 37.248 0 51.488l89.984 89.984-90.112 90.112c-14.176 14.176-14.24 37.28-0.032 51.488 14.176 14.176 37.248 14.208 51.488-0.032l90.048-90.048 89.984 89.984c14.144 14.144 37.248 14.24 51.52-0.032C674.368 636.96 674.4 613.92 660.192 599.68L660.192 599.68 660.192 599.68zM840.128 187.84c-177.216-177.216-465.696-177.28-642.976 0-177.28 177.28-177.216 465.76 0 642.976 177.28 177.28 465.696 177.344 643.008 0.032C1017.44 653.568 1017.44 365.152 840.128 187.84L840.128 187.84 840.128 187.84zM237.376 790.624C82.24 635.488 82.272 383.168 237.344 228.064c155.168-155.168 407.456-155.136 562.592-0.032 155.136 155.136 155.168 407.456 0 562.624C644.896 945.76 392.48 945.76 237.376 790.624L237.376 790.624 237.376 790.624zM237.376 790.624"  ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-female" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M903.261228 684.286216C760.643348 821.199405 543.864182 838.31358 384.132127 718.514564L298.561358 804.085231 418.360374 923.884247C441.179239 940.998421 441.179239 975.226769 424.065064 998.045634L418.360374 1003.750325C401.246199 1026.56919 367.017953 1032.273881 344.199088 1009.455016L338.494397 1003.750325 218.69528 883.95131 138.829304 963.817286C116.010439 986.636151 81.782192 992.340841 58.963327 969.521976L53.258535 963.817286C30.43967 946.703111 30.43967 912.474865 47.553844 889.656L53.258535 883.95131 138.829304 804.085231 19.030288 684.286216C-3.788577 667.172041-3.788577 632.943795 13.325597 610.12493L19.030288 604.420239C36.144462 581.601374 70.372709 581.601374 93.191574 598.715447L98.896264 604.420239 218.69528 724.219255 304.266049 638.648486C173.05755 461.802257 207.285898 210.794845 384.132127 79.586345 560.978254-51.622154 811.985768-17.393805 943.194267 159.452322 1062.993288 319.184376 1045.879114 541.668335 903.261228 684.286216L903.261228 684.286216 903.261228 684.286216ZM823.395252 199.385361C709.300927 85.291036 532.454698 85.291036 418.360374 199.385361 304.266049 313.479686 304.266049 490.325915 418.360374 604.420239 532.454698 718.514564 709.300927 718.514564 823.395252 604.420239L823.395252 604.420239C937.489577 490.325915 937.489577 307.774995 823.395252 199.385361L823.395252 199.385361 823.395252 199.385361Z"  ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-male" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M900.65 145.25c-0.21-1.26-0.3-2.55-0.75-3.78 0 0 0 0-0.030-0.030-0.75-2.040-1.98-3.72-3.15-5.52-0.030-0.060-0.060-0.090-0.090-0.15-0.78-1.2-1.14-2.52-2.1-3.63-0.21-0.24-0.51-0.33-0.72-0.57-1.5-1.62-3.36-2.7-5.22-3.96 0-0.030-0.030-0.030-0.060-0.060-1.41-0.96-2.67-2.13-4.2-2.82 0 0 0 0-0.030 0-3.78-1.68-7.92-2.73-12.3-2.73h-210c-16.59 0-30 13.44-30 30s13.41 30 30 30h130.62l-143.16 126.24c-55.14-41.4-123.36-66.24-197.46-66.24-181.95 0-330 148.050-330 330s148.050 330 330 330 330-148.050 330-330c0-86.16-33.45-164.46-87.75-223.29l147.75-130.26v113.55c0 16.56 13.41 30 30 30s30-13.44 30-30v-180c0-2.4-0.81-4.5-1.35-6.75zM722 572c0 148.89-121.11 270-270 270-148.86 0-270-121.11-270-270 0-148.86 121.14-270 270-270 148.89 0 270 121.14 270 270z" fill="#2c2c2c" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-anchor" viewBox="0 0 1691 1024">' +
    '' +
    '<path d="M1200.128 409.6H0v153.6h1213.952l-6.2464 6.4c-196.7104 204.6976-378.368 429.568-378.368 429.568s600.064-383.232 862.5152-501.0944c-262.4512-117.8624-680.0896-393.216-862.5152-492.032C989.44 146.688 1041.408 240.2816 1200.128 409.6z" fill="#3B3B3B" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-phone" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M640.581343 996.461986h-0.035305l-4.483753-1.059155c-104.079572-27.891066-224.576037-159.861703-322.406598-352.980854l-36.117165-71.316396C179.743267 377.91582 144.36751 202.096191 182.92073 100.664505 210.140998 29.136278 330.531547-10.546706 391.715366 2.445587c30.11529 6.425537 37.776507 24.14872 39.64768 34.175382 21.183088 70.610293 40.671529 189.659247 32.480734 229.130401l-0.564882 2.824411-1.553427 2.40075c-12.00375 19.135389-31.245055 25.419705-48.191524 30.962614-22.312853 7.308165-35.199231 12.498022-41.236411 33.998856-1.800562 6.531452-2.647886 37.776507 61.430954 167.417004l27.57332 54.440536c65.243911 125.227354 90.451785 142.597487 96.736101 144.892321 20.547595 7.555301 32.551345 0.141221 51.474903-13.769007 14.369195-10.626849 30.715477-22.665904 53.098941-21.324308l2.824411 0.176525 2.612581 1.16507c36.505521 16.452198 120.672991 102.137789 166.075409 162.085928 6.884504 7.20225 17.440742 26.443555-1.30629 59.983443-29.373882 52.675279-123.073741 120.178719-192.236523 105.456473z" fill="#AEAAAA" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-people" viewBox="0 0 1051 1024">' +
    '' +
    '<path d="M786.62573 335.152432C800.601946 162.732973 686.08 0 525.173622 0c-160.823351 0-275.456 162.705297-261.479784 335.152432 13.422703 164.919351 132.455784 277.559351 261.479784 277.559352 128.968649 0 248.140108-112.750703 261.452108-277.559352zM0 909.228973c0 48.404757 44.502486 67.085838 175.519135 81.255784 101.18227 10.931892 222.097297 10.931892 349.654487 10.931892 130.684541 0 260.317405 0 351.425729-10.931892 128.996324-15.415351 173.720216-32.851027 173.720217-81.255784 0-141.588757-238.702703-256.415135-527.470703-256.415135C234.080865 652.813838 0 767.640216 0 909.228973z" fill="#C2C2C2" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-funnel" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M996.736 568.96h-255.957333c-15.061333 0-24.064 12.501333-24.064 24.96v9.386667c0 15.573333 12.032 24.917333 24.064 24.917333h256c15.018667 0 24.064-12.458667 24.064-24.96v-6.229333c0-15.573333-12.032-28.074667-24.106667-28.074667z m0 155.946667h-255.957333c-15.061333 0-24.064 12.458667-24.064 24.917333v9.386667c0 15.573333 12.032 24.917333 24.064 24.917333h256c15.018667 0 24.064-12.458667 24.064-24.917333v-9.386667a24.149333 24.149333 0 0 0-24.106667-24.917333z m0 155.904h-255.957333c-15.061333 0-24.064 12.458667-24.064 24.96v12.458666c0 15.616 12.032 24.96 24.064 24.96h256c15.018667 0 24.064-12.458667 24.064-24.96v-12.458666c0-12.501333-12.032-24.96-24.106667-24.96zM879.36 216.576c5.973333-6.229333 12.032-12.458667 15.061333-18.688 30.08-37.418667 33.109333-93.568 9.002667-134.101333-24.064-40.533333-60.202667-62.378667-108.373333-62.378667H123.434667c-12.032 0-24.064 0-33.109334 3.114667C39.125333 16.981333 0 66.901333 0 123.008c0 34.304 12.032 65.493333 36.138667 87.338667 87.338667 93.568 174.634667 180.906667 261.973333 268.202666 2.986667 3.114667 2.986667 6.229333 2.986667 9.344v286.933334c3.029333 24.917333 18.090667 37.376 39.168 28.032 12.074667-6.229333 18.090667-18.730667 18.090666-34.304v-293.12c0-12.501333-2.986667-24.96-12.074666-34.304-87.296-90.453333-165.589333-180.906667-252.928-268.202667-6.016-6.229333-9.045333-9.386667-12.032-15.616-12.074667-15.573333-15.061333-31.146667-9.045334-49.877333 9.045333-21.845333 27.093333-43.648 51.2-43.648H800.981333c33.152 0 57.258667 40.533333 48.213334 74.837333-2.986667 12.458667-9.045333 18.688-18.090667 28.074667-93.312 93.525333-183.68 187.093333-277.034667 283.733333-9.002667 9.386667-15.061333 18.773333-15.061333 34.346667V977.493333c0 12.458667 3.029333 21.845333 12.074667 28.074667v3.114667h33.109333c12.032-9.386667 12.032-24.96 12.032-37.418667V503.466667c0-3.114667 0-6.229333 3.029333-9.344 93.354667-96.682667 192.725333-187.093333 280.064-277.546667z" fill="#727272" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-nike" viewBox="0 0 1365 1024">' +
    '' +
    '<path d="M30.122667 564.053333a52.906667 52.906667 0 0 1-5.12-65.28l23.893333-32.426666a41.728 41.728 0 0 1 58.538667-8.277334l262.741333 201.386667c37.290667 28.586667 96.938667 27.306667 133.12-2.901333L1259.008 27.050667a47.616 47.616 0 0 1 62.464 2.56l13.824 13.653333a41.472 41.472 0 0 1-0.853333 60.074667l-835.84 822.613333a83.882667 83.882667 0 0 1-119.893334-1.194667L30.122667 564.053333z" fill="#25B93D" ></path>' +
    '' +
    '</symbol>' +
    '' +
    '</svg>'
  var script = function() {
    var scripts = document.getElementsByTagName('script')
    return scripts[scripts.length - 1]
  }()
  var shouldInjectCss = script.getAttribute("data-injectcss")

  /**
   * document ready
   */
  var ready = function(fn) {
    if (document.addEventListener) {
      if (~["complete", "loaded", "interactive"].indexOf(document.readyState)) {
        setTimeout(fn, 0)
      } else {
        var loadFn = function() {
          document.removeEventListener("DOMContentLoaded", loadFn, false)
          fn()
        }
        document.addEventListener("DOMContentLoaded", loadFn, false)
      }
    } else if (document.attachEvent) {
      IEContentLoaded(window, fn)
    }

    function IEContentLoaded(w, fn) {
      var d = w.document,
        done = false,
        // only fire once
        init = function() {
          if (!done) {
            done = true
            fn()
          }
        }
        // polling for no errors
      var polling = function() {
        try {
          // throws errors until after ondocumentready
          d.documentElement.doScroll('left')
        } catch (e) {
          setTimeout(polling, 50)
          return
        }
        // no errors, fire

        init()
      };

      polling()
        // trying to always fire before onload
      d.onreadystatechange = function() {
        if (d.readyState == 'complete') {
          d.onreadystatechange = null
          init()
        }
      }
    }
  }

  /**
   * Insert el before target
   *
   * @param {Element} el
   * @param {Element} target
   */

  var before = function(el, target) {
    target.parentNode.insertBefore(el, target)
  }

  /**
   * Prepend el to target
   *
   * @param {Element} el
   * @param {Element} target
   */

  var prepend = function(el, target) {
    if (target.firstChild) {
      before(el, target.firstChild)
    } else {
      target.appendChild(el)
    }
  }

  function appendSvg() {
    var div, svg

    div = document.createElement('div')
    div.innerHTML = svgSprite
    svgSprite = null
    svg = div.getElementsByTagName('svg')[0]
    if (svg) {
      svg.setAttribute('aria-hidden', 'true')
      svg.style.position = 'absolute'
      svg.style.width = 0
      svg.style.height = 0
      svg.style.overflow = 'hidden'
      prepend(svg, document.body)
    }
  }

  if (shouldInjectCss && !window.__iconfont__svg__cssinject__) {
    window.__iconfont__svg__cssinject__ = true
    try {
      document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>");
    } catch (e) {
      console && console.log(e)
    }
  }

  ready(appendSvg)


})(window)