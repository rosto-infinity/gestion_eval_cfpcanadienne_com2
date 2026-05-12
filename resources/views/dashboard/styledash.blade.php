 <style>
        /* Box Info (Stats) */
        .box-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .box-info li {
            display: flex;
            align-items: center;
            padding: 20px;
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .box-info li:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.15);
        }

        .box-info li i {
            font-size: 32px;
            color: var(--primary);
            margin-right: 15px;
        }

        .box-info li h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: var(--foreground);
        }

        .box-info li p {
            font-size: 13px;
            color: var(--muted-foreground);
            margin: 0;
        }

        /* Layout principal */
        .table-data {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .order {
            background: var(--card);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }

        .order .head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .order .head h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--foreground);
        }

        .order .head a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .order .head a:hover {
            text-decoration: underline;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            color: var(--foreground);
            font-size: 14px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            color: var(--foreground);
        }

        table tr:hover {
            background: var(--accent);
        }

        .text-center {
            text-align: center;
        }

        /* Styles spécifiques au dashboard admin */
        .head-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .head-title .left h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0;
        }

        .head-title .left .breadcrumb {
            display: flex;
            align-items: center;
            color: var(--muted-foreground);
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
        }

        .head-title .left .breadcrumb li {
            display: flex;
            align-items: center;
        }

        .head-title .left .breadcrumb a {
            text-decoration: none;
            color: var(--muted-foreground);
            transition: color 0.2s;
        }

        .head-title .left .breadcrumb a:hover,
        .head-title .left .breadcrumb li.active {
            color: var(--primary);
        }

        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }

        .profile-header-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .profile-header-avatar-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--primary-foreground);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border: 3px solid var(--primary);
        }

        .profile-header-info h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--foreground);
        }

        .profile-header-info p {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: var(--muted-foreground);
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .role-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .role-stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .role-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .role-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .role-icon.superadmin {
            background: linear-gradient(135deg, #ff6b6b, #c92a2a);
        }

        .role-icon.admin {
            background: linear-gradient(135deg, #4dabf7, #1864ab);
        }

        .role-icon.manager {
            background: linear-gradient(135deg, #69db7c, #2f9e44);
        }

        .role-icon.student {
            background: linear-gradient(135deg, #ffd43b, #fab005);
        }

        .role-info h4 {
            margin: 0 0 0.25rem 0;
            font-size: 0.875rem;
            color: #64748b;
        }

        .role-info p {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .note-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .note-badge.success {
            background: #d4edda;
            color: #155724;
        }

        .note-badge.danger {
            background: #f8d7da;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .table-data {
                grid-template-columns: 1fr;
            }

            .role-stats-grid {
                grid-template-columns: 1fr;
            }

            .head-title {
                flex-direction: column;
                align-items: stretch;
            }

            .user-profile-header {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .role-stats-grid {
                grid-template-columns: 1fr;
            }

            .role-stat-card {
                padding: 1rem;
            }

            .role-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .head-title {
                margin-bottom: 20px;
            }

            .head-title .left h1 {
                font-size: 24px;
            }

            .user-profile-header {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .profile-header-info {
                text-align: center;
            }

            .order .head {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            table {
                font-size: 13px;
            }

            table th,
            table td {
                padding: 8px 10px;
            }
        }
    </style>