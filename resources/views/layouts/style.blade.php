<style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

    :root {
        --poppins: 'Poppins', sans-serif;
        --lato: 'Lato', sans-serif;
        
        /* Light theme colors */
        --light: #F9F9F9;
        --red: #e63c3c;
        --light-red: #ffd8cf;
        --grey: #eee;
        --dark-grey: #AAAAAA;
        --dark: #342E37;
        --yellow: #FFCE26;
        --light-yellow: #FFF2C6;
        --orange: #FD7238;
        --light-orange: #FFE0D3;
    }

    body.dark {
        --light: #0C0C1E;
        --grey: #060714;
        --dark: #FBFBFB;
        --red: #e63c3c;
    }

    body {
        background: var(--light);
        overflow-x: hidden;
        font-family: var(--lato);
    }

    /* ==================== */
    /* DESKTOP SIDEBAR STYLES */
    /* ==================== */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100%;
        background: var(--light);
        z-index: 2000;
        font-family: var(--lato);
        transition: all 0.3s ease;
        overflow-x: hidden;
        scrollbar-width: none;
    }

    #sidebar::-webkit-scrollbar {
        display: none;
    }

    #sidebar.hide {
        width: 60px;
    }

    #sidebar .brand {
        font-size: 24px;
        font-weight: 700;
        height: 56px;
        display: flex;
        align-items: center;
        color: var(--red);
        position: sticky;
        top: 0;
        left: 0;
        background: var(--light);
        z-index: 500;
        padding-bottom: 20px;
        box-sizing: content-box;
        padding-left: 13px;
        text-decoration: none;
    }

    #sidebar .brand img {
        height: 30px;
    }

    #sidebar .side-menu {
        width: 100%;
        margin-top: 48px;
    }

    #sidebar .side-menu li {
        height: 48px;
        background: transparent;
        margin-left: 6px;
        border-radius: 48px 0 0 48px;
        padding: 4px;
        list-style: none;
    }

    #sidebar .side-menu li.active {
        background: var(--grey);
        position: relative;
    }

    #sidebar .side-menu li.active::before {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        top: -40px;
        right: 0;
        box-shadow: 20px 20px 0 var(--grey);
        z-index: -1;
    }

    #sidebar .side-menu li.active::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        bottom: -40px;
        right: 0;
        box-shadow: 20px -20px 0 var(--grey);
        z-index: -1;
    }

    #sidebar .side-menu li a {
        width: 100%;
        height: 100%;
        background: var(--light);
        display: flex;
        align-items: center;
        border-radius: 48px;
        font-size: 16px;
        color: var(--dark);
        white-space: nowrap;
        overflow-x: hidden;
        text-decoration: none;
        padding: 0 12px;
        transition: all 0.3s ease;
    }

    #sidebar .side-menu.top li.active a {
        color: var(--red);
        font-weight: 900;
        font-size: 1.15rem;
    }

    #sidebar.hide .side-menu li a {
        width: calc(48px - (4px * 2));
        transition: width 0.3s ease;
    }

    #sidebar .side-menu li a.logout {
        color: var(--red);
    }

    #sidebar .side-menu.top li a:hover {
        color: var(--red);
        background: var(--grey);
    }

    #sidebar .side-menu li a .bx {
        min-width: calc(60px - ((4px + 6px) * 2));
        display: flex;
        justify-content: center;
        font-size: 20px;
    }

    #sidebar.hide .side-menu li a .bx {
        min-width: calc(48px - (4px * 2));
    }

    #sidebar.hide .side-menu li a .text {
        display: none;
    }

    /* ==================== */
    /* MOBILE SIDEBAR STYLES */
    /* ==================== */
    .mobile-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 320px;
        max-width: 80vw;
        height: 100%;
        background: var(--light);
        z-index: 9999;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .mobile-sidebar.show {
        transform: translateX(0);
    }

    .mobile-sidebar .brand {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid var(--grey);
        background: var(--light);
    }

    .mobile-sidebar .brand img {
        height: 30px;
    }

    .mobile-sidebar .close-btn {
        margin-left: auto;
        padding: 8px;
        border: none;
        background: transparent;
        color: var(--dark);
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .mobile-sidebar .close-btn:hover {
        background: var(--grey);
    }

    /* ==================== */
    /* CONTENT STYLES */
    /* ==================== */
    #content {
        position: relative;
        width: calc(100% - 200px);
        left: 200px;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    #sidebar.hide ~ #content {
        width: calc(100% - 60px);
        left: 60px;
    }

    /* ==================== */
    /* NAVBAR STYLES */
    /* ==================== */
    #content nav {
        height: 56px;
        background: var(--light);
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: var(--lato);
        position: sticky;
        top: 0;
        left: 0;
        z-index: 1000;
        border-bottom: 1px solid var(--grey);
    }

    #content nav::before {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        bottom: -40px;
        left: 0;
        border-radius: 50%;
        box-shadow: -20px -20px 0 var(--light);
    }

    #content nav a {
        color: var(--dark);
        text-decoration: none;
    }

    #content nav .bx.bx-dock-left {
        cursor: pointer;
        color: var(--dark);
        font-size: 24px;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    #content nav .bx.bx-dock-left:hover {
        background: var(--grey);
        color: var(--red);
    }

    #content nav .nav-link {
        font-size: 16px;
        transition: all 0.3s ease;
    }

    #content nav .nav-link:hover {
        color: var(--red);
    }

    #content nav form {
        max-width: 400px;
        width: 100%;
        margin-right: auto;
    }

    #content nav form .form-input {
        display: flex;
        align-items: center;
        height: 36px;
        background: var(--grey);
        border-radius: 36px;
        overflow: hidden;
    }

    #content nav form .form-input input {
        flex-grow: 1;
        padding: 0 16px;
        height: 100%;
        border: none;
        background: transparent;
        outline: none;
        color: var(--dark);
        font-family: var(--lato);
    }

    #content nav form .form-input button {
        width: 36px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: var(--red);
        color: var(--light);
        font-size: 18px;
        border: none;
        outline: none;
        border-radius: 0 36px 36px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #content nav .form-input button:hover {
        background: var(--dark);
    }

    #content nav .notification {
        font-size: 20px;
        position: relative;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    #content nav .notification:hover {
        background: var(--grey);
        color: var(--red);
    }

    #content nav .notification .num {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--light);
        background: var(--red);
        color: var(--light);
        font-weight: 700;
        font-size: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #content nav .profile img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    #content nav .profile img:hover {
        border-color: var(--red);
    }

    /* ==================== */
    /* MAIN CONTENT STYLES */
    /* ==================== */
    #content main {
        width: 100%;
        padding: 36px 24px;
        font-family: var(--poppins);
        min-height: calc(100vh - 56px);
        overflow-y: auto;
    }

    #content main .head-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        grid-gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    #content main .head-title .left h1 {
        font-size: 36px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
    }

    #content main .head-title .left .breadcrumb {
        display: flex;
        align-items: center;
        grid-gap: 16px;
    }

    #content main .head-title .left .breadcrumb li {
        color: var(--dark);
        list-style: none;
    }

    #content main .head-title .left .breadcrumb li a {
        color: var(--dark-grey);
        text-decoration: none;
        pointer-events: none;
    }

    #content main .head-title .left .breadcrumb li a.active {
        color: var(--red);
        background-color: rgba(230, 60, 60, 0.1);
        pointer-events: unset;
        padding: 4px 8px;
        border-radius: 4px;
    }

    #content main .head-title .btn-download {
        height: 36px;
        padding: 0 16px;
        border-radius: 36px;
        background: var(--red);
        color: var(--light);
        display: flex;
        justify-content: center;
        align-items: center;
        grid-gap: 10px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #content main .head-title .btn-download:hover {
        background: var(--dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* ==================== */
    /* TABLE STYLES */
    /* ==================== */
    #content main .table-data {
        display: flex;
        flex-wrap: wrap;
        grid-gap: 24px;
        margin-top: 24px;
        width: 100%;
        color: var(--dark);
    }

    #content main .table-data > div {
        border-radius: 20px;
        background: var(--light);
        padding: 24px;
        overflow-x: auto;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    #content main .table-data .head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        grid-gap: 16px;
        margin-bottom: 24px;
    }

    #content main .table-data .head h3 {
        font-size: 24px;
        font-weight: 600;
        color: var(--dark);
    }

    #content main .table-data .head .bx {
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    #content main .table-data .head .bx:hover {
        background: var(--grey);
        color: var(--red);
    }

    #content main .table-data .order {
        flex-grow: 1;
        flex-basis: 500px;
    }

    #content main .table-data .order table {
        width: 100%;
        border-collapse: collapse;
    }

    #content main .table-data .order table th {
        padding: 12px 16px;
        font-size: 13px;
        text-align: left;
        border-bottom: 2px solid var(--grey);
        color: var(--dark);
        font-weight: 600;
        background: var(--light);
    }

    #content main .table-data .order table td {
        padding: 16px;
        border-bottom: 1px solid var(--grey);
    }

    #content main .table-data .order table tr td:first-child {
        display: flex;
        align-items: center;
        grid-gap: 12px;
        padding-left: 6px;
    }

    #content main .table-data .order table td img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    #content main .table-data .order table tbody tr:hover {
        background: var(--grey);
    }

    #content main .table-data .order table tr td .status {
        font-size: 10px;
        padding: 6px 16px;
        color: var(--light);
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #content main .table-data .order table tr td .status.completed {
        background: var(--red);
    }

    #content main .table-data .order table tr td .status.process {
        background: var(--yellow);
        color: var(--dark);
    }

    #content main .table-data .order table tr td .status.pending {
        background: var(--orange);
    }

    /* ==================== */
    /* RESPONSIVE STYLES */
    /* ==================== */
    
    /* Tablets and below */
    @media screen and (max-width: 1024px) {
        #sidebar {
            width: 200px;
        }

        #content {
            width: calc(100% - 200px);
            left: 200px;
        }

        #content main .table-data {
            flex-direction: column;
        }

        #content main .table-data .order {
            flex-basis: auto;
        }
    }

    /* Mobile landscape and below */
    @media screen and (max-width: 768px) {
        #sidebar {
            transform: translateX(-100%);
            width: 280px;
            max-width: 80vw;
        }

        #sidebar.show {
            transform: translateX(0);
        }

        #content {
            width: 100%;
            left: 0;
        }

        #content nav {
            padding: 0 16px;
        }

        #content nav .nav-link {
            display: none;
        }

        #content main {
            padding: 24px 16px;
        }

        #content main .head-title {
            flex-direction: column;
            align-items: flex-start;
            grid-gap: 12px;
        }

        #content main .head-title .left h1 {
            font-size: 28px;
        }

        #content main .table-data .head {
            flex-direction: column;
            align-items: flex-start;
            grid-gap: 12px;
        }
    }

    /* Mobile portrait */
    @media screen and (max-width: 576px) {
        #content nav {
            padding: 0 12px;
        }

        #content nav form .form-input input {
            display: none;
        }

        #content nav form .form-input {
            background: transparent;
            border-radius: 0;
        }

        #content nav form .form-input button {
            width: auto;
            height: auto;
            background: transparent;
            border-radius: none;
            color: var(--dark);
            padding: 8px;
        }

        #content nav form.show .form-input input {
            display: block;
            width: 100%;
            background: var(--grey);
            border-radius: 36px;
            padding: 0 16px;
        }

        #content nav form.show .form-input {
            background: var(--grey);
            border-radius: 36px;
            margin: 0 8px;
        }

        #content nav form.show .form-input button {
            width: 36px;
            height: 100%;
            border-radius: 0 36px 36px 0;
            color: var(--light);
            background: var(--red);
        }

        #content nav form.show ~ .notification,
        #content nav form.show ~ .profile {
            display: none;
        }

        #content main {
            padding: 20px 12px;
        }

        #content main .head-title .left h1 {
            font-size: 24px;
        }

        #content main .table-data > div {
            padding: 16px;
            border-radius: 16px;
        }

        #content main .table-data .order table {
            font-size: 14px;
        }

        #content main .table-data .order table th,
        #content main .table-data .order table td {
            padding: 8px;
        }
    }

    /* Dark mode specific adjustments */
    body.dark #sidebar,
    body.dark .mobile-sidebar {
        background: var(--light);
        border-right: 1px solid var(--grey);
    }

    body.dark #content nav {
        background: var(--light);
        border-bottom-color: var(--grey);
    }

    body.dark #content main .table-data > div {
        background: var(--light);
        border: 1px solid var(--grey);
    }

    body.dark #content main .table-data .order table th {
        background: var(--light);
        border-bottom-color: var(--grey);
    }

    body.dark #content main .table-data .order table tbody tr:hover {
        background: var(--grey);
    }
</style>