from bs4 import BeautifulSoup
import requests
import os
from datetime import date
import re
from src.environment import RESUME_DATASET_PATH
import requests


def resume_downloader(url):
    response = requests.get(url)
    if response.status_code != 200:
        print("Error")
        exit(1)
    soup = BeautifulSoup(response.content, "html.parser")

    a_list = soup.find_all("a")

    hrefs = []
    for a in a_list:
        if "href" in a.attrs.keys():
            href = a.attrs["href"]
            if "resume-samples" in href:
                if href[-8:-2] != "sample" and href[-1] != "#":
                    hrefs.append(a.attrs["href"])

    for url in hrefs:
        response = requests.get(url)
        if response.status_code != 200:
            print("Error")
            exit(1)
        soup = BeautifulSoup(response.content, "html.parser")
        print(url)
        a_list = soup.find_all("a")
        hrefs = []
        for a in a_list:
            if "href" in a.attrs.keys():
                href = a.attrs["href"]
                if "resume-samples" in href:
                    if href[-8:-2] != "sample" and href[-1] != "#":
                        hrefs.append(a.attrs["href"])

        hrefs = [x for x in hrefs if x.endswith(".pdf")]

        count = 0
        print("SUBTREE")
        for download_link in hrefs:
            name = download_link.split("/")[-1]
            r = requests.get(download_link, allow_redirects=True)
            print(name)
            open(os.path.join(RESUME_DATASET_PATH, name), 'wb').write(r.content)
            count += 1
            if count > 800:
                return


down_urls = ["https://www.qwikresume.com/resume-samples/art-design/",
             "https://www.qwikresume.com/resume-samples/business-development/",
             "https://www.qwikresume.com/resume-samples/medical/",
             "https://www.qwikresume.com/resume-samples/accounting/",
             "https://www.qwikresume.com/resume-samples/designer/"]

for down in down_urls:
    resume_downloader(down)
