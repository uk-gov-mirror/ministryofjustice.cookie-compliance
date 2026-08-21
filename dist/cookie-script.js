window.dataLayer = window.dataLayer || [];
function gtag() {
	dataLayer.push(arguments);
}
gtag("consent", "default", {
	ad_user_data: "denied",
	ad_personalization: "denied",
	ad_storage: "denied",
	analytics_storage: "denied",
	wait_for_update: 500,
});
dataLayer.push({ "gtm.start": new Date().getTime(), event: "gtm.js" });

(function (w, d, s, l, i) {
	w[l] = w[l] || [];
	w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
	var f = d.getElementsByTagName(s)[0],
		j = d.createElement(s),
		dl = l != "dataLayer" ? "&l=" + l : "";
	j.async = true;
	j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
	f.parentNode.insertBefore(j, f);
})(window, document, "script", "dataLayer", cookie_consent_object.gtmcode);

window.onload = function () {
	setReturnLink(); //Tells the confirmation banner where to link to

	let consent = get_cookie_consent();

	// If a consent decision exists, ensure GTM gets the correct state
	if (consent) {
		if (consent == "granted" || consent == "denied") {
			update_gtm_consent(consent);
			set_cookie_page_toggle(consent);
			hide_cookie_banner();
		} else {
			killCookie("cookie_consent"); //if neither "granted" nor "denied", the cookie is wiped
			show_cookie_banner();
		}
		if (consent == "denied") {
			clearAnalyticalCookies();
		}
	} else {
		clearAnalyticalCookies();
		set_cookie_page_toggle("denied");
		show_cookie_banner();
	}

	if (document.getElementById("save-cookies-button")) {
		const saveButton = document.getElementById("save-cookies-button");
		saveButton.addEventListener("click", function () {
			if (document.getElementById("accept-analytical-cookies").checked) {
				update_cookie_consent("granted");
				update_gtm_consent("granted");
			} else {
				clearAnalyticalCookies();
				update_cookie_consent("denied");
				update_gtm_consent("denied");
			}

			const confirmationBanner = document.getElementById("cookie-settings-confirmation");
			confirmationBanner.classList.remove("cc:hidden");
			confirmationBanner.scrollIntoView({ behavior: "instant" });
			saveButton.blur();

			hide_cookie_banner();
		});
	}

	const grantButton = document.getElementById("cookie-accept");
	grantButton.addEventListener("click", function () {
		update_cookie_consent("granted");
		update_gtm_consent("granted");
		set_cookie_page_toggle("granted");
		hide_cookie_banner();
	});

	const declineButton = document.getElementById("cookie-decline");
	declineButton.addEventListener("click", function () {
		clearAnalyticalCookies();
		update_cookie_consent("denied");
		update_gtm_consent("denied");
		set_cookie_page_toggle("denied");
		hide_cookie_banner();
	});
};

function set_cookie_page_toggle(consent) {
	if (document.getElementById("analytical-cookies-control")) {
		if (consent == "granted") {
			document.getElementById("accept-analytical-cookies").checked = true;
		} else {
			document.getElementById("reject-analytical-cookies").checked = true;
		}
	}
}

function update_gtm_consent(consent) {
	function gtag() {
		dataLayer.push(arguments);
	}

	gtag("consent", "update", {
		ad_user_data: consent,
		ad_personalization: consent,
		ad_storage: consent,
		analytics_storage: consent,
	});
}

function show_cookie_banner() {
	document.getElementById("cookie-compliance-banner").classList.remove("cc:hidden");
	setTimeout(function () {
		// Tiny delay to allow the height of the element without hidden to be rendered
		window.scrollTo(0, 0);
	}, 1);
}

function hide_cookie_banner() {
	document.getElementById("cookie-compliance-banner").classList.add("cc:hidden");
}

/* Store consent by cookie */

function update_cookie_consent(consent) {
	var d = new Date();
	d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * 365);
	const secureString = cookie_consent_object?.isSsl == 1 ? "; Secure" : "";
	document.cookie = "cookie_consent=" + consent + "; path=/; expires=" + d.toGMTString() + secureString;
}

function get_cookie_consent() {
	var nameEQ = "cookie_consent=";
	var ca = document.cookie.split(";");
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == " ") c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function clearAnalyticalCookies() {
	// Function to clear Google Analytics cookies if consent is withdrawn
	killCookieAndRelated("_ga");
	killCookieAndRelated("_ga_");
	killCookie("_gid");
	killCookieAndRelated("_gat");
}

function killCookieAndRelated(name) {
	//function for killing all cookies which start with <name>
	// e.g. _ga will kill of _ga and _ga_123ABC
	killCookie(name);
	const cookies = document.cookie.split(";"); // array of cookies
	for (var i = 0; i < cookies.length; i++) {
		let cookie = cookies[i].trim();
		if (!cookie) continue;
		let eqPos = cookie.indexOf("=");
		let fullname = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
		if (fullname.substring(0, name.length) == name) {
			killCookie(fullname);
		}
	}
}

function killCookie(name) {
	// kills cookies of name for our domains
	document.cookie = name + "=; expires=Sun, 01 May 1707 00:00:00 UTC; path=/;";
	document.cookie = name + "=; expires=Sun, 01 May 1707 00:00:00 UTC; path=/;domain=" + location.host; // e.g. magistrates.judiciary.uk
	document.cookie = name + "=; expires=Sun, 01 May 1707 00:00:00 UTC; path=/;domain=." + location.host; // e.g. .magistrates.judiciary.uk
	let domain = location.host.split(".");
	if (domain.length >= 3) domain[0] = "";
	domain = domain.join(".");
	document.cookie = name + "=; expires=Sun, 01 May 1707 00:00:00 UTC; path=/;domain=" + domain; // e.g. .judiciary.uk
}

function setReturnLink() {
	let returnLink = document.getElementById("cookie-confirmation-return");
	if (returnLink) {
		let returnURL = document.referrer;
		if (document.referrer !== "") {
			returnLink.href = returnURL;
			returnLink.classList.remove("cc:hidden");
		}
	}
}
