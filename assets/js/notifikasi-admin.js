(function () {
    "use strict";

    const config = document.currentScript.dataset;

    const endpoint = config.endpoint;
    const detailUrl = config.detail;
    const waitingUrl = config.waiting;

    const adminId = config.admin || "admin";

    const storageKey = "notifikasi_admin_" + adminId;
    const pendingKey = storageKey + "_pending";

    let lastId = localStorage.getItem(storageKey);
    let pendingIds = [];

    try {
        pendingIds = JSON.parse(
            localStorage.getItem(pendingKey) || "[]"
        );
    } catch (error) {
        pendingIds = [];
    }

    function simpanPending() {
        localStorage.setItem(
            pendingKey,
            JSON.stringify(pendingIds)
        );
    }

    function buatPopUp() {
        let popup = document.getElementById("adminNotification");

        if (popup) {
            return popup;
        }

        const style = document.createElement("style");

        style.textContent = `
            #adminNotification {
                position: fixed;
                bottom: 22px;
                right: 22px;
                width: min(360px, calc(100% - 32px));
                padding: 17px;
                background: #ffffff;
                color: #263238;
                border-radius: 15px;
                box-shadow: 0 5px 25px rgba(0,0,0,.18);
                z-index: 99999;
                cursor: pointer;
                border-left: 5px solid #287fa7;
                display: none;
                animation: notifMasuk .3s ease;
            }

            #adminNotification strong {
                display: block;
                margin-bottom: 6px;
                font-size: 15px;
            }

            #adminNotification span {
                display: block;
                font-size: 13px;
                line-height: 1.5;
                color: #65747c;
            }

            @keyframes notifMasuk {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media(max-width: 480px) {
                #adminNotification {
                    right: 16px;
                    bottom: 16px;
                }
            }
        `;

        document.head.appendChild(style);

        popup = document.createElement("div");
        popup.id = "adminNotification";
        popup.setAttribute("role", "button");
        popup.setAttribute("tabindex", "0");

        popup.addEventListener("click", bukaLaporan);

        popup.addEventListener("keydown", function (event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                bukaLaporan();
            }
        });

        document.body.appendChild(popup);

        return popup;
    }

    function tampilkanPopUp() {
        if (pendingIds.length === 0) {
            return;
        }

        const popup = buatPopUp();
        const jumlah = pendingIds.length;

        popup.innerHTML = "";

        const judul = document.createElement("strong");
        const keterangan = document.createElement("span");

        judul.textContent = "Pengaduan Baru";

        keterangan.textContent = jumlah === 1
            ? "Ada 1 laporan pengaduan baru. Tekan untuk melihat laporan."
            : "Ada " + jumlah + " laporan pengaduan baru. Tekan untuk membuka laporan menunggu.";

        popup.appendChild(judul);
        popup.appendChild(keterangan);

        popup.style.display = "block";
    }

    function bukaLaporan() {
        if (pendingIds.length === 0) {
            return;
        }

        const jumlah = pendingIds.length;
        const idTerbaru = Math.max(...pendingIds);

        pendingIds = [];
        simpanPending();

        if (jumlah === 1) {
            window.location.href = detailUrl + "?id=" + encodeURIComponent(idTerbaru);
        } else {
            window.location.href = waitingUrl;
        }
    }

    async function periksaLaporan() {
        try {
            const response = await fetch(
                endpoint + "?last_id=" + encodeURIComponent(lastId),
                { cache: "no-store" }
            );

            if (!response.ok) {
                return;
            }

            const result = await response.json();

            if (!result.success || !Array.isArray(result.reports)) {
                return;
            }

            if (result.reports.length > 0) {
                result.reports.forEach(function (report) {
                    const id = Number(report.id_aspirasi);

                    if (
                        Number.isInteger(id) &&
                        id > 0 &&
                        !pendingIds.includes(id)
                    ) {
                        pendingIds.push(id);
                    }
                });

                pendingIds.sort(function (a, b) {
                    return a - b;
                });

                const idTerbesar = Math.max(
                    ...result.reports.map(function (report) {
                        return Number(report.id_aspirasi);
                    })
                );

                if (idTerbesar > Number(lastId)) {
                    lastId = String(idTerbesar);
                    localStorage.setItem(storageKey, lastId);
                }

                simpanPending();
                tampilkanPopUp();
            }
        } catch (error) {
            console.error("Gagal memeriksa notifikasi:", error);
        }
    }

    async function mulaiNotifikasi() {
        if (lastId === null) {
            try {
                const response = await fetch(
                    endpoint + "?init=1",
                    { cache: "no-store" }
                );

                const result = await response.json();

                if (!result.success) {
                    return;
                }

                lastId = String(result.latest_id);
                localStorage.setItem(storageKey, lastId);
            } catch (error) {
                console.error("Gagal memulai notifikasi:", error);
                return;
            }
        }

        if (pendingIds.length > 0) {
            tampilkanPopUp();
        }

        periksaLaporan();

        window.setInterval(periksaLaporan, 5000);
    }

    mulaiNotifikasi();
})();