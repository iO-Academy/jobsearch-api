# JobSearch RESTful API

<details>
<summary>Run the API locally</summary>

<p></p>
<p>
Clone this repo into your docker `html` folder:

```bash
git clone git@github.com:iO-Academy/jobsearch-api.git
```

Once cloned, you must install the vendor code by running:

```bash
composer install
```

To run the application locally:
```bash
composer start
```

That's it! Now go build something cool.
</p>
</details>

## API documentation

This API only supports GET requests.

* **URL**

  /jobs

* **Method:**

  `GET`

* **URL Params**

   **Required:**

   There are no required URL Params, this URL will return all jobs if no params are passed

   **Optional:**

    `search=[alphanumeric]` - a search term which will search `job_title` and `company`. If no skill filter is provided, it will also search for jobs with skills like your search term.

    `skill=[integer]` - the ID of a skill. When used alone, this will return all jobs with this skill, when combined with search, it will return jobs with this skill that match the search term in the `job_title` or `company` fields.

    `type=[alphabetical]` - filter jobs by the job type, the available values are: `Part time`, `Full time`, `Contract`. Note: not all jobs have a type

  * **Success Response:**

      * **Code:** 200 <br />
        **Content:** <br />

        ```json
        [
            {
                "id": "300",
                "job_title": "Junior software engineer",
                "company": "Demivee",
                "logo": "https://dummyimage.com/250/000000/89e632&text=Logo",
                "salary": "127228",
                "type": "Full time",
                "skills": [
                    {"id": "5","skill": "Ruby"}, {"id": "8","skill": "Python"}
                ]
            },
            {
                "id": "439",
                "job_title": "Junior software engineer",
                "company": "Yata",
                "logo": "https://dummyimage.com/250/000000/d91c4e&text=Logo",
                "salary": "129291",
                "type": null,
                "skills": [{"id": "2","skill": "JavaScript"}]
            }
        ]
        ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`
