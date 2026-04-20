export default function Profile_Sidebar({user}) {
    const appURL = window.REACT_APP.APP_URL;
    const pageTitle = document.title;

    return (
        <>
            <div className="col-lg-3">
                <div className="offcanvas-lg offcanvas-end" tabIndex="-1" id="offcanvasSidebar">
                    <div className="offcanvas-header">
                        <button type="button" className="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                    </div>
                    <div className="offcanvas-body p-3 p-lg-0">
                        <div className=" border rounded-3 p-3 w-100">
                            <div className="list-group list-group-light list-group-borderless">
                                <a className={"list-group-item" + (pageTitle === "Profile" ? " active" : "")}
                                   href={appURL + "/view-profile?id=" + user.userId}><i className="bi bi-person me-2"></i>Profile</a>
                                <a className={"list-group-item" + (pageTitle === "Favorites" ? " active" : "")}
                                   href={appURL + "/view-profile/favorites?id=" + user.userId}><i className="bi bi-star-fill me-2"></i>Favorites</a>
                                <a className={"list-group-item" + (pageTitle === "Ratings" ? " active" : "")}
                                   href={appURL + "/view-profile/ratings?id=" + user.userId}><i className="bi bi-film me-2"></i>Ratings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </>
    );
}


