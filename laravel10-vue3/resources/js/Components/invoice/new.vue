<template>
  <div class="container">
    <div class="invoices">
      <div class="card__header">
        <div>
          <h2 class="invoice__title">New Invoice</h2>
        </div>
        <div></div>
      </div>

      <div class="card__content">
        <div class="card__content--header">
          <div>
            <p class="my-1">Customer</p>
            <select name="" id="" class="input" v-model="customer_id">
              <option value="" disabled selected>Select Customer</option>
              <option
                :value="customer.id"
                v-for="customer in allCustomers"
                :key="customer.id"
              >
                {{ customer.first_name }}
              </option>
            </select>
          </div>
          <div>
            <p class="my-1">Date</p>
            <input
              id="date"
              placeholder="dd-mm-yyyy"
              type="date"
              class="input"
              v-model="form.date"
            />
            <!---->
            <p class="my-1">Due Date</p>
            <input id="due_date" type="date" class="input" v-model="form.due_date" />
          </div>
          <div>
            <p class="my-1">Numero</p>
            <input type="text" class="input" v-model="form.number" />
            <p class="my-1">Reference(Optional)</p>
            <input type="text" class="input" v-model="form.referece" />
          </div>
        </div>
        <br /><br />
        <div class="table">
          <div class="table--heading2">
            <p>Item Description</p>
            <p>Unit Price</p>
            <p>Qty</p>
            <p>Total</p>
            <p></p>
          </div>

          <!-- item 1 -->
          <div class="table--items2" v-for="(itemcart, i) in listCard" :key="itemcart.id">
            <p>#{{ itemcart.item_code }} {{ itemcart.description }}</p>
            <p>
              <input type="text" class="input" readonly v-model="itemcart.unit_price" />
            </p>
            <p>
              <input type="text" class="input" v-model="itemcart.quantity" />
            </p>
            <p v-if="itemcart.quantity">
              $ {{ itemcart.quantity * itemcart.unit_price }}
            </p>
            <p v-else></p>
            <p
              style="color: red; font-size: 24px; cursor: pointer"
              @click="removeItem(i)"
            >
              &times;
            </p>
          </div>
          <div style="padding: 10px 30px !important">
            <button class="btn btn-sm btn__open--modal" @click="openModal()">
              Add New Line
            </button>
          </div>
        </div>

        <div class="table__footer">
          <div class="document-footer">
            <p>Terms and Conditions</p>
            <textarea
              cols="50"
              rows="7"
              class="textarea"
              v-model="form.tre_n_condition"
            ></textarea>
          </div>
          <div>
            <div class="table__footer--subtotal">
              <p>Sub Total</p>
              <span>$ {{ subTotal() }}</span>
            </div>
            <div class="table__footer--discount">
              <p>Discount</p>
              <input type="text" class="input" v-model="form.discount" />
            </div>
            <div class="table__footer--total">
              <p>Grand Total</p>
              <span>$ {{ Total() }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="card__header" style="margin-top: 40px">
        <div></div>
        <div>
          <a class="btn btn-secondary" @click="onSave()"> Save </a>
        </div>
      </div>
    </div>

    <!--==================== add modal items ====================-->
    <div class="modal main__modal" :class="{ show: showModal }">
      <div class="modal__content">
        <span class="modal__close btn__close--modal" @click="closeModal">×</span>
        <h3 class="modal__title">Add Item</h3>
        <hr />
        <br />
        <div class="modal__items">
          <ul style="list-style: none">
            <li
              v-for="(item, i) in listProducts"
              :key="item.id"
              style="
                display: grid;
                grid-template-columns: 30px 350px 15px;
                align-items: center;
                padding-bottom: 5px;
              "
            >
              <p>{{ i + 1 }}</p>
              <a href=""> {{ item.item_code }} {{ item.description }} </a>
              <button
                @click="addCard(item)"
                style="
                  border: 1px solid #e0e0e0;
                  width: 35px;
                  height: 35px;
                  cursor: pointer;
                "
              >
                +
              </button>
            </li>
          </ul>

          <!-- <select class="input my-1">
            <option value="None">None</option>
            <option value="None">LBC Padala</option>
          </select> -->
        </div>
        <br />
        <hr />
        <div class="model__footer">
          <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
            Cancel
          </button>
          <button class="btn btn-light btn__close--modal">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from "vue-router";
const router = useRouter();
import axios from "axios";
import { ref, onMounted } from "vue"; // Import ref and onMounted from Vue

export default {
  setup() {
    // Define reactive variables using ref
    const allCustomers = ref([]);
    const form = ref([]);
    const customer_id = ref("");
    const item = ref([]);
    const listCard = ref([]);
    const listProducts = ref([]);
    const showModal = ref(false);
    const hideModal = ref(true);

    // Define methods
    const indexForm = async () => {
      try {
        const response = await axios.get("/api/create_invoice");
        form.value = response.data;
        // console.log(response.data);
      } catch (error) {
        console.error("Error fetching form data", error);
      }
    };

    const getAllCustomer = async () => {
      try {
        const response = await axios.get("/api/customers");
        allCustomers.value = response.data.customers;
        // console.log(allCustomers.value);
      } catch (error) {
        console.error("Error fetching customer data", error);
      }
    };

    const getProducts = async () => {
      try {
        let response = await axios.get("/api/products");
        listProducts.value = response.data.products;
        // console.log(response);
      } catch (error) {
        console.error("Error fetching products data", error);
      }
    };

    const addCard = (item) => {
      const itemCard = {
        id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: item.quantity,
      };
      listCard.value.push(itemCard);

      closeModal();
    };

    const openModal = () => {
      showModal.value = !showModal.value;
    };

    const closeModal = () => {
      showModal.value = !hideModal.value;
    };

    const removeItem = (i) => {
      listCard.value.splice(i, 1);
    };

    const subTotal = () => {
      let total = 0;
      listCard.value.map((data) => {
        total += data.quantity * data.unit_price;
      });
      return total;
    };

    const Total = () => {
      return subTotal() - form.value.discount;
    };

    const onSave = () => {
      if (listCard.value.length >= 1) {
        let subtotal = 0;
        subtotal = subTotal();

        let total = 0;
        total = Total();

        const formData = new FormData();
        formData.append("invoice_item", JSON.stringify(listCard.value));
        formData.append("customer_id", customer_id.value);
        formData.append("date", form.value.date);
        formData.append("due_date", form.value.due_date);
        formData.append("number", form.value.number);
        formData.append("referece", form.value.referece);
        formData.append("discount", form.value.discount);
        formData.append("subtotal", subtotal);
        formData.append("toal", total);
        formData.append("tre_n_condition", form.value.tre_n_condition);

        axios.post("/api/add_invoice", formData);
        listCard.value = [];
        router.push("/");
      }
    };

    // Use onMounted hook
    onMounted(() => {
      indexForm();
      getAllCustomer();
      getProducts();
    });

    // Return the data and methods you want to expose
    return {
      allCustomers,
      form,
      customer_id,
      item,
      listCard,
      showModal,
      hideModal,
      openModal,
      closeModal,
      addCard,
      removeItem,
      subTotal,
      Total,
      onSave,
      listProducts,
    };
  },
};
</script>

<style></style>
