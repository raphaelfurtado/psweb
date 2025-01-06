<?php echo $this->include('template/header', array('titulo' => $titulo)); ?>

<?php echo $this->include('template/topbar'); ?>

<?php echo $this->include('template/sidebar', array('role' => $role)); ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a type="button" class="btn btn-primary text-white">
                        <i class="mdi mdi-plus btn-icon-prepend"></i>
                        Adicionar
                    </a>
                </div>
                <br />
                <h4 class="card-title">Documentos Cadastrados</h4>
                <div class="table-responsive">
                    <table id="example" class="table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                                <th>Extn.</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td>Bradley</td>
                                <td>Greer</td>
                                <td>Software Engineer</td>
                                <td>London</td>
                                <td>41</td>
                                <td>2012-10-13</td>
                                <td>$132,000</td>
                                <td>2558</td>
                                <td>b.greer@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Dai</td>
                                <td>Rios</td>
                                <td>Personnel Lead</td>
                                <td>Edinburgh</td>
                                <td>35</td>
                                <td>2012-09-26</td>
                                <td>$217,500</td>
                                <td>2290</td>
                                <td>d.rios@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jenette</td>
                                <td>Caldwell</td>
                                <td>Development Lead</td>
                                <td>New York</td>
                                <td>30</td>
                                <td>2011-09-03</td>
                                <td>$345,000</td>
                                <td>1937</td>
                                <td>j.caldwell@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Yuri</td>
                                <td>Berry</td>
                                <td>Chief Marketing Officer (CMO)</td>
                                <td>New York</td>
                                <td>40</td>
                                <td>2009-06-25</td>
                                <td>$675,000</td>
                                <td>6154</td>
                                <td>y.berry@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Caesar</td>
                                <td>Vance</td>
                                <td>Pre-Sales Support</td>
                                <td>New York</td>
                                <td>21</td>
                                <td>2011-12-12</td>
                                <td>$106,450</td>
                                <td>8330</td>
                                <td>c.vance@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Doris</td>
                                <td>Wilder</td>
                                <td>Sales Assistant</td>
                                <td>Sydney</td>
                                <td>23</td>
                                <td>2010-09-20</td>
                                <td>$85,600</td>
                                <td>3023</td>
                                <td>d.wilder@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Angelica</td>
                                <td>Ramos</td>
                                <td>Chief Executive Officer (CEO)</td>
                                <td>London</td>
                                <td>47</td>
                                <td>2009-10-09</td>
                                <td>$1,200,000</td>
                                <td>5797</td>
                                <td>a.ramos@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Gavin</td>
                                <td>Joyce</td>
                                <td>Developer</td>
                                <td>Edinburgh</td>
                                <td>42</td>
                                <td>2010-12-22</td>
                                <td>$92,575</td>
                                <td>8822</td>
                                <td>g.joyce@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jennifer</td>
                                <td>Chang</td>
                                <td>Regional Director</td>
                                <td>Singapore</td>
                                <td>28</td>
                                <td>2010-11-14</td>
                                <td>$357,650</td>
                                <td>9239</td>
                                <td>j.chang@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Brenden</td>
                                <td>Wagner</td>
                                <td>Software Engineer</td>
                                <td>San Francisco</td>
                                <td>28</td>
                                <td>2011-06-07</td>
                                <td>$206,850</td>
                                <td>1314</td>
                                <td>b.wagner@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Fiona</td>
                                <td>Green</td>
                                <td>Chief Operating Officer (COO)</td>
                                <td>San Francisco</td>
                                <td>48</td>
                                <td>2010-03-11</td>
                                <td>$850,000</td>
                                <td>2947</td>
                                <td>f.green@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Shou</td>
                                <td>Itou</td>
                                <td>Regional Marketing</td>
                                <td>Tokyo</td>
                                <td>20</td>
                                <td>2011-08-14</td>
                                <td>$163,000</td>
                                <td>8899</td>
                                <td>s.itou@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Michelle</td>
                                <td>House</td>
                                <td>Integration Specialist</td>
                                <td>Sydney</td>
                                <td>37</td>
                                <td>2011-06-02</td>
                                <td>$95,400</td>
                                <td>2769</td>
                                <td>m.house@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Suki</td>
                                <td>Burks</td>
                                <td>Developer</td>
                                <td>London</td>
                                <td>53</td>
                                <td>2009-10-22</td>
                                <td>$114,500</td>
                                <td>6832</td>
                                <td>s.burks@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Prescott</td>
                                <td>Bartlett</td>
                                <td>Technical Author</td>
                                <td>London</td>
                                <td>27</td>
                                <td>2011-05-07</td>
                                <td>$145,000</td>
                                <td>3606</td>
                                <td>p.bartlett@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Gavin</td>
                                <td>Cortez</td>
                                <td>Team Leader</td>
                                <td>San Francisco</td>
                                <td>22</td>
                                <td>2008-10-26</td>
                                <td>$235,500</td>
                                <td>2860</td>
                                <td>g.cortez@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Martena</td>
                                <td>Mccray</td>
                                <td>Post-Sales support</td>
                                <td>Edinburgh</td>
                                <td>46</td>
                                <td>2011-03-09</td>
                                <td>$324,050</td>
                                <td>8240</td>
                                <td>m.mccray@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Unity</td>
                                <td>Butler</td>
                                <td>Marketing Designer</td>
                                <td>San Francisco</td>
                                <td>47</td>
                                <td>2009-12-09</td>
                                <td>$85,675</td>
                                <td>5384</td>
                                <td>u.butler@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Howard</td>
                                <td>Hatfield</td>
                                <td>Office Manager</td>
                                <td>San Francisco</td>
                                <td>51</td>
                                <td>2008-12-16</td>
                                <td>$164,500</td>
                                <td>7031</td>
                                <td>h.hatfield@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Hope</td>
                                <td>Fuentes</td>
                                <td>Secretary</td>
                                <td>San Francisco</td>
                                <td>41</td>
                                <td>2010-02-12</td>
                                <td>$109,850</td>
                                <td>6318</td>
                                <td>h.fuentes@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Vivian</td>
                                <td>Harrell</td>
                                <td>Financial Controller</td>
                                <td>San Francisco</td>
                                <td>62</td>
                                <td>2009-02-14</td>
                                <td>$452,500</td>
                                <td>9422</td>
                                <td>v.harrell@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Timothy</td>
                                <td>Mooney</td>
                                <td>Office Manager</td>
                                <td>London</td>
                                <td>37</td>
                                <td>2008-12-11</td>
                                <td>$136,200</td>
                                <td>7580</td>
                                <td>t.mooney@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jackson</td>
                                <td>Bradshaw</td>
                                <td>Director</td>
                                <td>New York</td>
                                <td>65</td>
                                <td>2008-09-26</td>
                                <td>$645,750</td>
                                <td>1042</td>
                                <td>j.bradshaw@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Olivia</td>
                                <td>Liang</td>
                                <td>Support Engineer</td>
                                <td>Singapore</td>
                                <td>64</td>
                                <td>2011-02-03</td>
                                <td>$234,500</td>
                                <td>2120</td>
                                <td>o.liang@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Bruno</td>
                                <td>Nash</td>
                                <td>Software Engineer</td>
                                <td>London</td>
                                <td>38</td>
                                <td>2011-05-03</td>
                                <td>$163,500</td>
                                <td>6222</td>
                                <td>b.nash@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Sakura</td>
                                <td>Yamamoto</td>
                                <td>Support Engineer</td>
                                <td>Tokyo</td>
                                <td>37</td>
                                <td>2009-08-19</td>
                                <td>$139,575</td>
                                <td>9383</td>
                                <td>s.yamamoto@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Thor</td>
                                <td>Walton</td>
                                <td>Developer</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>2013-08-11</td>
                                <td>$98,540</td>
                                <td>8327</td>
                                <td>t.walton@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Finn</td>
                                <td>Camacho</td>
                                <td>Support Engineer</td>
                                <td>San Francisco</td>
                                <td>47</td>
                                <td>2009-07-07</td>
                                <td>$87,500</td>
                                <td>2927</td>
                                <td>f.camacho@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Serge</td>
                                <td>Baldwin</td>
                                <td>Data Coordinator</td>
                                <td>Singapore</td>
                                <td>64</td>
                                <td>2012-04-09</td>
                                <td>$138,575</td>
                                <td>8352</td>
                                <td>s.baldwin@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zenaida</td>
                                <td>Frank</td>
                                <td>Software Engineer</td>
                                <td>New York</td>
                                <td>63</td>
                                <td>2010-01-04</td>
                                <td>$125,250</td>
                                <td>7439</td>
                                <td>z.frank@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zorita</td>
                                <td>Serrano</td>
                                <td>Software Engineer</td>
                                <td>San Francisco</td>
                                <td>56</td>
                                <td>2012-06-01</td>
                                <td>$115,000</td>
                                <td>4389</td>
                                <td>z.serrano@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jennifer</td>
                                <td>Acosta</td>
                                <td>Junior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>43</td>
                                <td>2013-02-01</td>
                                <td>$75,650</td>
                                <td>3431</td>
                                <td>j.acosta@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Cara</td>
                                <td>Stevens</td>
                                <td>Sales Assistant</td>
                                <td>New York</td>
                                <td>46</td>
                                <td>2011-12-06</td>
                                <td>$145,600</td>
                                <td>3990</td>
                                <td>c.stevens@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Hermione</td>
                                <td>Butler</td>
                                <td>Regional Director</td>
                                <td>London</td>
                                <td>47</td>
                                <td>2011-03-21</td>
                                <td>$356,250</td>
                                <td>1016</td>
                                <td>h.butler@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Lael</td>
                                <td>Greer</td>
                                <td>Systems Administrator</td>
                                <td>London</td>
                                <td>21</td>
                                <td>2009-02-27</td>
                                <td>$103,500</td>
                                <td>6733</td>
                                <td>l.greer@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jonas</td>
                                <td>Alexander</td>
                                <td>Developer</td>
                                <td>San Francisco</td>
                                <td>30</td>
                                <td>2010-07-14</td>
                                <td>$86,500</td>
                                <td>8196</td>
                                <td>j.alexander@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Shad</td>
                                <td>Decker</td>
                                <td>Regional Director</td>
                                <td>Edinburgh</td>
                                <td>51</td>
                                <td>2008-11-13</td>
                                <td>$183,000</td>
                                <td>6373</td>
                                <td>s.decker@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Michael</td>
                                <td>Bruce</td>
                                <td>Javascript Developer</td>
                                <td>Singapore</td>
                                <td>29</td>
                                <td>2011-06-27</td>
                                <td>$183,000</td>
                                <td>5384</td>
                                <td>m.bruce@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Donna</td>
                                <td>Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27</td>
                                <td>2011-01-25</td>
                                <td>$112,000</td>
                                <td>4226</td>
                                <td>d.snider@datatables.net</td>
                            </tr>
                            <!-- Adicione mais linhas conforme necessário -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>