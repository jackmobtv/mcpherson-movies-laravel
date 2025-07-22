import {useEffect, useState} from "react";

export default function Layout({children}) {
    const appURL = window.REACT_APP.APP_URL;

    // Initialize theme based on localStorage or system preference
    const getInitialTheme = () => {
        const saved = localStorage.getItem("dark-mode");
        if (saved) {
            return saved === "dark";
        }
        return window.matchMedia("(prefers-color-scheme: dark)").matches;
    };

    const [isDarkMode, setIsDarkMode] = useState(getInitialTheme);

    // Apply theme class to document on theme change
    useEffect(() => {
        document.documentElement.dataset.bsTheme = isDarkMode ? "dark" : "light";
        localStorage.setItem("dark-mode", isDarkMode ? "dark" : "light");
    }, [isDarkMode]);

    // Listen to system theme changes if no explicit preference
    useEffect(() => {
        const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
        const handleChange = () => {
            if (!localStorage.getItem("dark-mode")) {
                setIsDarkMode(mediaQuery.matches);
            }
        };
        mediaQuery.addEventListener('change', handleChange);
        return () => mediaQuery.removeEventListener('change', handleChange);
    }, []);

    // Handle toggle switch change
    const handleToggle = (e) => {
        setIsDarkMode(e.target.checked);
    };

    return (
        <>
            <nav className="navbar navbar-expand-lg" aria-label="navbar">
                <div className="container">
                    <a className="navbar-brand" href={appURL}>Movies</a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse" id="navbar">
                        <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                            <li className="nav-item">
                                <a className="nav-link" aria-current="page" href={appURL + "/movies"}>Movies</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" aria-current="page" href={appURL + "/actors"}>Actors</a>
                            </li>
                            <li className="nav-item dropdown">
                                <a className="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                   aria-expanded="false">Admin</a>
                                <ul className="dropdown-menu">
                                    <li><a className="dropdown-item" href={appURL + "/users"}>Users</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div className="d-lg-flex col-lg-3 justify-content-lg-end">
                            <a href={appURL + "/login"} className="btn btn-outline-primary me-2">Login</a>
                            <a href={appURL + "/signup"} className="btn btn-outline-success">Sign Up</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div className="container">
                <div className="alert alert-success my-2"
                     role="alert"></div>
                <div className="alert alert-danger my-2"
                     role="alert"></div>
                <div className="alert alert-warning my-2"
                     role="alert"></div>
            </div>

            {children}

            <li className="nav-item align-items-center d-flex ms-5 mt-2">
                <i className="fas fa-sun"></i>
                <div className="ms-2 form-check form-switch">
                    <input className="form-check-input" type="checkbox" role="switch" id="themingSwitcher" checked={isDarkMode} onChange={handleToggle}/>
                </div>
                <i className="fas fa-moon"></i>
            </li>
            <div className="container foot">
                <footer className="py-3 my-4">
                    <ul className="nav justify-content-center border-bottom pb-3 mb-3">
                        <li className="nav-item"><a href="/" className="nav-link px-2 text-body-secondary">Home</a></li>
                        <li className="nav-item"><a href="/pricing"
                                                    className="nav-link px-2 text-body-secondary">Pricing</a></li>
                        <li className="nav-item"><a href="/terms"
                                                    className="nav-link px-2 text-body-secondary">Terms</a></li>
                        <li className="nav-item"><a href="/about"
                                                    className="nav-link px-2 text-body-secondary">About</a></li>
                    </ul>
                    <p className="text-center text-body-secondary">&copy; {new Date().getFullYear()} Company, Inc</p>
                </footer>
            </div>
        </>
    );
}
